const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

const batchSelect = document.querySelectorAll('.select_dlc_batch');

export function goodsOptionAttachEventListener(select) {
    select.forEach(select => {
        select.addEventListener('change', handleChangeOption)
    })
}

function handleChangeOption(event) {
    const select = event.currentTarget;
    const selectedOption = select.options[select.selectedIndex];
    const selectedValue = selectedOption.value;
    const targetGoodsUl = selectedOption.closest('ul');

    let dataUpdate = new FormData();
    dataUpdate.append('context', 'changeBatch')
    dataUpdate.append('batch_id', selectedValue)

    fetch(url.toString(), {method: 'POST', body: dataUpdate})
        .then(response => response.json())
        .then(data => {

            const quantity = data.quantity;
            const updatedAtDate = data.updated_at_date;
            const updatedAtTime = data.updated_at_time;

            changeBatchInfos(targetGoodsUl, quantity, updatedAtDate, updatedAtTime)

        })
}

function changeBatchInfos(targetGoodsUl, quantity, updatedAtDate, updatedAtTime) {
    const quantityLi = targetGoodsUl.querySelector('.quantity');
    const updatedAtDateLi = targetGoodsUl.querySelector('.updated_at_date');
    const updatedAtTimeLi = targetGoodsUl.querySelector('.updated_at_time');

    quantityLi.innerHTML = quantity;
    updatedAtDateLi.innerHTML = updatedAtDate;
    updatedAtTimeLi.innerHTML = updatedAtTime;
}

goodsOptionAttachEventListener(batchSelect);