export default class Modal {
    oneInput(title, callback, showCancel = true, confirmText = "save", input = "input", didOpen = false, html = "text", csrf = false) {
        Swal.fire({
            title: title,
            [input]: html,
            query: {
                _token: csrf
            },
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: showCancel,
            confirmButtonText: confirmText,
            showLoaderOnConfirm: true,
            ...(didOpen && {didOpen: didOpen()}),
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                try {
                callback(result);
                } catch(err) {
                    console.log(err)
                }
            }
        });
    }
    success(title) {
        Swal.fire({
            icon: "success",
            title,
            confirmButtonText: "Ok"
        });
    }
}
