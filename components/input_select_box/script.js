window.addEventListener('load', (event) => {

    //document.querySelector('.data_select_box-container.state')
    let els = document.querySelectorAll("[name=input_select_box]")
    els.forEach(function (el, indx) {
        el.addEventListener('change', function (e) {

            let country_shortname = getInputLabel(el)

           // console.log(country_shortname)

            let el_togle = document.getElementById('data_select_box_states')
            console.log(el_togle)

            let chkCounty = chkCountry(country_shortname)

            toggleStateSelectbox(el_togle, chkCounty)

            if (chkCounty >= 0) {
                let country_id = getCountryID(el)
                addStates(country_id)
            }


            let data = getDataSelectBox();
            let task = 'getComponentPartner'
            sendRequest(data, task).then(data => {
                document.querySelector('.section-main').innerHTML = data['componet'];
                initLoader()
                //    console.log(data)
            })
            this.blur()
        })
        el.addEventListener('focus', function (e) {
            el.value = ""
        })
    })

    function getCountryID(el) {
        let el_value = el.value
        let list_id = el.getAttribute('list');
        let el_list = document.getElementById(list_id)
        let el_list_otption = el_list.querySelector('option[value="' + el_value + '"]');

        return el_list_otption.dataset.country_id
    }

    // function toggleStateSelectbox(el, flag) {
    //
    //     if (flag >= 0) {
    //         el.removeAttribute('disabled')
    //     } else {
    //         el.setAttribute('disabled', "");
    //
    //     }
    // }

    function addStates(country_id) {
        let task = "getComponentSelectBox"
        let data = [
            {
                column: "country_id",
                data: country_id
            }
        ]
        initLoader()
        sendRequest(data, task).then(data => {

            let el_container_select_state=document.querySelector('.data_select_box-container.states')
            let el_parent=el_container_select_state.parentElement

            el_container_select_state.remove()
            el_parent.insertAdjacentHTML('beforeend', data['componet'])

            document.getElementById('data_select_box_states').addEventListener('change', function (e) {

            let data = getDataSelectBox();
            let task = 'getComponentPartner'
                sendRequest(data, task).then(data => {
                        document.querySelector('.section-main').innerHTML = data['componet'];
                    initLoader()
                    })
                })

        })
    }
    // function chkCountry(data) {
    //     let $arr = ['US', 'CA']
    //     return $arr.indexOf(data)
    // }
    // async function sendRequest2(data, task) {
    //     console.log(data)
    //     let obj = {task: task, data: data}
    //     const rawResponse = await fetch('/ajax/ajax.php',
    //         {
    //             method: 'POST',
    //             headers: {
    //                 'Accept': 'application/json',
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify(obj)
    //         }
    //     );
    //   //  const content = await rawResponse.text();
    //     return rawResponse.text();
    // }

});
