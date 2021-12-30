
let copyLink = (link) => {
    let company_code = link;
        let input = $(`<input>`);
        $("body").append(input);
        input.val(company_code).select();
        document.execCommand("copy");
        input.remove();
        Swal.fire({
            title: 'Pesan!',
            text: "Link berhasil dicopy",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#c9184a',
            confirmButtonText: 'Oke'
        });
}


