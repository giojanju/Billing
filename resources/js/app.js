/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.sweetAler = (callback, message = 'Are you sure?', buttons = true) => {
    swal({
        title: message,
        icon: "warning",
        buttons: buttons,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                callback();
            }
        });
}

$('.btn.btn-danger, .sweet-alert').click(e => {
    e.preventDefault();

    sweetAler(() => {
        window.location.href = e.target.href;
    });
});

$(document).on('click', '.allow-or-deny-permissions', e => {
    const actionType = e.target.name
    const dataSelectType = e.target.dataset.selectType

    if (dataSelectType === 'allow') {
        if ($('.allow-or-deny-permissions:selected')) {
            $(`input[data-type='${actionType}']`).prop('checked', true)
            $(`input[data-select-type='deny'][name='${actionType}']`).prop('checked', false)
        }
    } else if (dataSelectType === 'deny') {
        if ($('.allow-or-deny-permissions:selected')) {
            $(`input[data-type='${actionType}']`).prop('checked', false)
            $(`input[data-select-type='allow'][name='${actionType}']`).prop('checked', false)
        }
    }
})
