
console.log('Default Подключаемые скрипты через глобальную пременную')
window.addEventListener('load', (e)=>{

    let el_search_input=document.querySelector(".section-search-input")

    el_search_input.addEventListener('change', function (e){
        let task = "getComponentPartner"
        let data = getData(this)
        sendRequest(data, task).then(data =>{
            document.querySelector('.main').innerHTML=data['componet'];
            console.log(data)
        })
    })
    console.log(el_search_input)

    document.getElementById("search-btn").addEventListener('click', function (e)
    {
        console.log('sadfg')
        let task = "getComponentPartner"
        let data = getData(el_search_input)
        sendRequest(data, task).then(data =>{
            document.querySelector('.main').innerHTML=data['componet'];
            console.log(data)
        })
    })

    function getData(el){
        let value=el.value
        let data = [
            {
                column: "company",
                data: value,
                sfx: "OR"
            },
            {
                column: "address",
                data: value,
                sfx: ""
            }
        ]
        return data
    }
})

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
        } else if (el.value.length > 0) {

            let state_id = getInputLabel(el)
            data[indx] = {
                column: el.dataset.column,
                data: state_id,
                sfx: sfx
            }
        }
    })
    return data;
}

function toggleStateSelectbox(el, flag){

    if(flag<0){
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

async function sendRequest(data, task) {
    console.log(data)
    let obj = {task: task, data: data}

    initLoader()

    const rawResponse = await fetch('/ajax/ajax.php',
        {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(obj)
        }
    );
    //const content = rawResponse.json();
    return rawResponse.json();
}

function initLoader(){
    console.log('initLoader')
    let el=document.querySelector(".loader-container")
    console.log(el.style.display)
    if(el.style.display==="none"){
        console.log(el.style.display)
        el.style.display="block"
        console.log(el.style.display)
    }
    else{
        console.log(el.style.display)
        el.style.display="none"
        console.log(el.style.display)
    }

}