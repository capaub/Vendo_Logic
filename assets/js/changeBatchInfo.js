let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let batchSelect = document.querySelectorAll('.select_dlc_batch');


export function goodsOptionAttachEventListener(select) {
    select.forEach(select => {
        select.addEventListener('change', () => {
            let selectedOption = select.options[select.selectedIndex];
            let selectedValue = selectedOption.value;
            let targetGoodsUl = selectedOption.closest('ul');

            let dataUpdate = new FormData();
            dataUpdate.append('context','changeBatch')
            dataUpdate.append('batch_id', selectedValue)

            fetch(url.toString(), {method: 'POST', body: dataUpdate})
                .then(response => response.json())
                .then(data => {

                    let quantity = data.quantity;
                    let updatedAtDate = data.updated_at_date;
                    let updatedAtTime = data.updated_at_time;

                    changeBatchInfos(targetGoodsUl, quantity, updatedAtDate, updatedAtTime)

                })
        })
    })
}

function changeBatchInfos(targetGoodsUl, quantity, updatedAtDate, updatedAtTime) {
    let quantityLi = targetGoodsUl.querySelector('.quantity');
    let updatedAtDateLi = targetGoodsUl.querySelector('.updated_at_date');
    let updatedAtTimeLi = targetGoodsUl.querySelector('.updated_at_time');

    quantityLi.innerHTML = quantity;
    updatedAtDateLi.innerHTML = updatedAtDate;
    updatedAtTimeLi.innerHTML = updatedAtTime;
}

goodsOptionAttachEventListener(batchSelect);