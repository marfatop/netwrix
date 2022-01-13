window.addEventListener('load', async (e) => {
///////////////////
    const CLASS_NAME_SELECT = 'select';
    const CLASS_NAME_ACTIVE = 'select_show';
    const CLASS_NAME_SELECTED = 'select__option_selected';
    const SELECTOR_ACTIVE = '.select_show';
    const SELECTOR_DATA = '[data-select]';
    const SELECTOR_DATA_TOGGLE = '[data-select="toggle"]';
    const SELECTOR_OPTION_SELECTED = '.select__option_selected';

    class CustomSelect {
        constructor(target, params) {
            this._elRoot = typeof target === 'string' ? document.querySelector(target) : target;
            this._params = params || {};
            if (this._params['options']) {
                this._elRoot.classList.add(CLASS_NAME_SELECT);
                this._elRoot.innerHTML = CustomSelect.template(this._params);
            }
            this._elToggle = this._elRoot.querySelector(SELECTOR_DATA_TOGGLE);
            this._elRoot.addEventListener('click', this._onClick.bind(this));
            this._elRoot.dataset.forquery=true
        }

        _onClick(e) {
            const target = e.target;

            const type = target.closest(SELECTOR_DATA).dataset.select;

            switch (type) {
                case 'toggle':
                    this.toggle();
                    break;
                case 'option':
                    this._changeValue(target);
                    break;
            }
        }

        _update(option) {

            const selected = this._elRoot.querySelector(SELECTOR_OPTION_SELECTED);
            if (selected) {
                selected.classList.remove(CLASS_NAME_SELECTED);
            }
            option.classList.add(CLASS_NAME_SELECTED);
            this._elToggle.textContent = option.textContent;
            this._elToggle.value = option.dataset['value'];
            this._elToggle.dataset.index = option.dataset['index'];
            this._elRoot.dispatchEvent(new CustomEvent('select.change'));
            this._params.onSelected ? this._params.onSelected(this, option) : null;
            return option.dataset['value'];
        }

        _reset() {
            const selected = this._elRoot.querySelector(SELECTOR_OPTION_SELECTED);
            if (selected) {
                selected.classList.remove(CLASS_NAME_SELECTED);
            }
            this._elToggle.textContent = 'Выберите из списка';
            this._elToggle.value = '';
            this._elToggle.dataset.index = -1;
            this._elRoot.dispatchEvent(new CustomEvent('select.change'));
            this._params.onSelected ? this._params.onSelected(this, null) : null;
            return '';
        }

        _changeValue(option) {
            if (option.classList.contains(CLASS_NAME_SELECTED)) {
                return;
            }
            this._update(option);

            let data = getDataSelectBox();
            let task = 'getComponentPartner'

            getDataInputSelectBox(data, task).then((result)=>{
                document.querySelector('.section-main').innerHTML = result['componet'];
            })
            this.hide();
        }

        show() {
            document.querySelectorAll(SELECTOR_ACTIVE).forEach(select => {
                select.classList.remove(CLASS_NAME_ACTIVE);

            });
            this._elRoot.classList.add(CLASS_NAME_ACTIVE);

        }

        hide() {
            this._elRoot.classList.remove(CLASS_NAME_ACTIVE);
        }

        toggle() {




            if (this._elRoot.classList.contains(CLASS_NAME_ACTIVE)) {
                this.hide();
            } else {
                this.show();
            }
        }

        dispose() {
            this._elRoot.removeEventListener('click', this._onClick);
        }

        get value() {
            return this._elToggle.value;
        }

        set value(value) {
            let isExists = false;
            this._elRoot.querySelectorAll('.select__option').forEach((option) => {
                if (option.dataset['value'] === value) {
                    isExists = true;
                    return this._update(option);
                }
            });
            if (!isExists) {
                return this._reset();
            }
        }

        get selectedIndex() {
            return this._elToggle.dataset['index'];
        }

        set selectedIndex(index) {
            const option = this._elRoot.querySelector(`.select__option[data-index="${index}"]`);
            if (option) {
                return this._update(option);
            }
            return this._reset();
        }
    }

    CustomSelect.template = params => {
        const name = params['name'];
        const options = params['options'];
        const targetValue = params['targetValue'];
        let items = [];
        let selectedIndex = -1;
        let selectedValue = '';
        let selectedContent = 'Выберите из списка';
        items.push(`<li class="select__option" data-select="option" data-value=""  data-index="0">Статус</li>`);
        options.forEach((option, index) => {
            let selectedClass = '';
            // selectedClass = ' select__option_selected';
            if (option[0] === targetValue) {
                selectedClass = ' select__option_selected';
                selectedIndex = index;
                selectedValue = option[0];
                selectedContent = option[0];
            }
            items.push(`<li class="select__option${selectedClass}" data-select="option" data-value="${option[0]}" data-index="${index+1}">${option[0]}</li>`);
        });
        return `<button data-column="status" data-forquery="true"  type="button" class="select__toggle" name="${name}" value="" data-selectvalue="${selectedContent}" data-select="toggle" data-index="${selectedIndex}">${selectedContent}</button>
  <div class="select__dropdown">
    <ul  class="select__options">${items.join('')}</ul>
  </div>`;
    };


    document.addEventListener('click', (e) => {
        if (!e.target.closest('.select')) {
            document.querySelectorAll(SELECTOR_ACTIVE).forEach(select => {
                select.classList.remove(CLASS_NAME_ACTIVE);
            });
        }
    });


    let data_custom_select_box =
        {
            tbl: 'partner_locator',
            column: "status",
            sort_field: "status",
            sort_direction: 'desc'

        }


    let task = "getDataOptions"
    let result_data_select_options = await getDataCustomSelectBox(data_custom_select_box, task)

    let comp_sel1 = new CustomSelect('#container_data_select_box_partner', {
        name: 'partner',
        options: result_data_select_options
    });

    ///**///

    async function getDataCustomSelectBox(data, task) {

        let obj = {task: task, data: data}
        let res = ''

        initLoader()

        const rawResponse = await fetch('/components/data_select_box/ajax/ajax.php',
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            }
        );
        initLoader()
        if (rawResponse.ok) {

            let data = await rawResponse.text()

            if (json = JSON.parse(data)) {

                res = json['data']

            } else {
                res = data
            }
        } else {
            console.log('Error request')
        }
        return res;
    }


    async function getDataSelectBox(data, task) {

        let obj = {task: task, data: data}
        let res = ''

        initLoader()

        const rawResponse = await fetch('/components/data_select_box/ajax/ajax.php',
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            }
        );
        initLoader()
        if (rawResponse.ok) {

            let data = await rawResponse.text()

            if (json = JSON.parse(data)) {
                res = json['data']

            } else {
                res = data
            }
        } else {
            console.log('Error request')
        }
        return res;
    }

    let el=document.getElementById('data_select_box_country');
    el.addEventListener('change', async function (e) {

        let country_shortname = getInputLabel(el)

        let el_togle = document.getElementById('data_select_box_states')

        let chkCounty = chkCountry(country_shortname)

        toggleStateSelectbox(el_togle, chkCounty)

        if (chkCounty >= 0) {
            let country_id = getCountryID(el)
            addStates(country_id)
        }

        let data = getDataSelectBox();
        let task = 'getComponentPartner'

        let res=await getDataInputSelectBox(data, task)

        document.querySelector('.section-main').innerHTML = res['componet'];

        this.blur()
    })

    el.addEventListener('focus', function (e) {
        el.value = ""
    })


    async function getDataInputSelectBox(data, task) {

        let obj = {task: task, data: data}
        let res=''

        initLoader()

        const rawResponse = await fetch('/components/input_select_box/ajax/ajax.php',
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            }
        );
        initLoader()
        if (rawResponse.ok) {
            let data=await rawResponse.text()

            if(json=JSON.parse(data)){
                res=json['data']
            }
            else{
                res= data
            }
        }
        else{
            console.log('Error request')
        }
        return res;
    }


    function getCountryID(el) {
        let el_value = el.value
        let list_id = el.getAttribute('list');
        let el_list = document.getElementById(list_id)
        let el_list_otption = el_list.querySelector('option[value="' + el_value + '"]');

        return el_list_otption.dataset.country_id
    }



    async function  addStates(country_id) {
        let task = "getComponentSelectBox"
        let data = [
            {
                column: "country_id",
                data: country_id
            }
        ]
        let obj = {task: task, data: data}
        let res=''

        const rawResponse = await fetch('/components/input_select_box/ajax/ajax.php',
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            }
        );

        if (rawResponse.ok) {
            let data=await rawResponse.text()

            if(json=JSON.parse(data)){
                res=json['data']

                let el_container_select_state=document.querySelector('.data_select_box-container.states')
                let el_parent=el_container_select_state.parentElement

                el_container_select_state.remove()
                el_parent.insertAdjacentHTML('beforeend', res['componet'])

                document.getElementById('data_select_box_states').addEventListener('change', function (e) {

                    let data = getDataSelectBox();
                    let task = 'getComponentPartner'
                    getDataInputSelectBox(data, task).then(data => {
                        document.querySelector('.section-main').innerHTML = data['componet'];

                    })
                })
            }
            else{
                res= data
            }
        }
        else{
            console.log('Error request')
        }
    }

    function getInputLabel(el) {
        let el_value = el.value
        let list_id = el.getAttribute('list');
        let el_list = document.getElementById(list_id)
        let el_list_otption = el_list.querySelector('option[value="' + el_value + '"]');

        return el_list_otption.getAttribute('label')
    }

    function getDataSelectBox() {
        let els = document.querySelectorAll("[data-forquery='true']")
        let data = []

        els.forEach(function (el, indx) {

            let sfx="AND"
            if (el.options && el.selectedIndex > 0) {
                data[indx] = {
                    column: el.dataset.column,
                    data: el.options[el.selectedIndex].value,
                    sfx: sfx
                }
            } else if (el.type==="text" && el.value.length > 0) {

                let state_id = getInputLabel(el)
                data[indx] = {
                    column: el.dataset.column,
                    data: state_id,
                    sfx: sfx
                }
            }else if(el.type==="button" && el.value.length > 0){
                let val= el.value || ''
                data[indx] = {
                    column: el.dataset.column,
                    data:val,
                    sfx: sfx
                }
            }
        })
        return data;
    }

    function toggleStateSelectbox(el, flag){

        if(flag<0){
            el.getElementsByTagName('option')[0].setAttribute('selected', true)
            el.setAttribute('disabled', "");
        }
        else{
            el.removeAttribute('disabled')
        }
    }

    function chkCountry(data){
        let $arr=['US', 'CA']
        return $arr.indexOf(data)
    }

});
