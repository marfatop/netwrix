window.addEventListener('load', (e)=>{
        let els=document.querySelectorAll("[name=data_select_box]")
        els.forEach( function (el, indx){

            el.addEventListener('change', function (e){

                if(el.id!='data_select_box_states'){

                    let country_shortname=getInputLabel(document.getElementById("data_select_box_country"))

                    let chkCounty=chkCountry(country_shortname)
                    let el_togle=document.getElementById('data_select_box_states')

                    toggleStateSelectbox(el_togle, chkCounty)
                }

                let data=getDataSelectBox();
                let task= 'getComponentPartner'

                    sendRequest(data, task).then(data =>{
                    document.querySelector('.section-main').innerHTML=data['componet'];
                    initLoader()

                })
            })
        })



    // function getInputLabel(el)
    // {
    //     let el_value=el.value
    //     let list_id=el.getAttribute('list');
    //     let el_list=document.getElementById(list_id)
    //     let el_list_otption=el_list.querySelector('option[value="'+el_value+'"]');
    //
    //     return el_list_otption.getAttribute('label')
    // }

    });
