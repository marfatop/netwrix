window.addEventListener('load', async (event) => {
let el=document.getElementById('input_search')

    el.addEventListener('search', function (e)
    {
        let task = "getComponentPartner"
        let data = getData(el)

        getDataInputSearchBox(data, task).then((res)=>{
        document.querySelector('.section-main').innerHTML=res['componet'];
        })
    })


    document.getElementById("search-btn").addEventListener('click', function (e)
    {

        let task = "getComponentPartner"
        let data = getData(el)

         getDataInputSearchBox(data, task).then((res)=>{
                document.querySelector('.section-main').innerHTML=res['componet'];
        })
    })

    async function getDataInputSearchBox(data, task) {

        let obj = {task: task, data: data}
        let res = ''
        initLoader()
        const rawResponse = await fetch('/components/input_search_box/ajax/ajax.php',
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

});
