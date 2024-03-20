<style>
    .search-con {
        position: relative;
    }

    .sbox {
        position: absolute;
        z-index: 9;
        max-height: 50vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>

<div class="form-group search-con">
    <input type="search" id="search" class="form-control py-1" placeholder="Scan Item to add" autofocus>
    <div class="sbox rounded-bottom border shadow bg-white p-2" style="width: 100%; display: none">
    </div>
</div>


<script src="{{ asset('assets/js/jquery.min.js?v=3.5') }}"></script>


<script>
    $(function() {


        const money_format = (num) => {
            var numb = new Intl.NumberFormat();
            return '₦ ' + numb.format(num);
        }


        function nformat(num){
            var numb = new Intl.NumberFormat();
            return numb.format(num);
        }


        $("#search").on('keyup', function(e) {
            e.preventDefault()
            param = $('#search');

            str = param.val().trim()

            if (!str) {
                return;
            }

            $.ajax({
                method: 'get',
                url: '/search',
                data: {
                    's': str
                },
                beforeSend: () => {
                    body = $('.sbox');
                    body.show();
                    body.html(`
                        <a class=" mt-3 py-2 bt" href="javscript:;" >
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Fetch Items ...
                        </a>
                    `)
                }
            }).done((res) => {
                console.log(res);
                body.html(``);

                if (res.length == 0) {
                    body.html(`
                        <div class="bg-danger mt-2  text-white p-2 rounded" >
                            No item found
                        </div>
                    `)
                    return;
                }




                string = '';

                res.map((item, index) => {
                    string += (`
                        <tr class=" search_item ${(item.quantity > 0) ? ` ` : `bg-danger text-white`} " data-data='${JSON.stringify(item)}' style="cursor: pointer" >
                            <td>#${item.id}</td>
                            <td>         
                                <span class="fw-bold"> ${item.name} </span> 
                            </td>
                            <td>${money_format(item.price)}</td>
                            <td> ${ (item.quantity > 0) ?   nformat(item.quantity) : `Out of Stock`} </td>
                        </tr>
                    `)
                })


                body.append(`
                    <table class="table table-hover table-sm ">
                        <thead>
                            <tr>
                                <th>#Item</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Aval Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${string}
                        <tbody>
                </table>
                `)

            }).fail((res) => {
                console.log(res);
            })
        })
    })
</script>
