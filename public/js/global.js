function previewImage(input = null)
{
    const inputImage = input ? input : document.querySelector("#banner");
    const img_tag = input ? inputImage.nextElementSibling.nextElementSibling : $(".img-preview");
    const image = new FileReader();
    image.readAsDataURL(inputImage.files[0]);
    image.onload = e => { // saat image sudah di load, maka :
        $(img_tag).attr("src", e.target.result);  // ganti value atribut src pada image
    };
}

function fetchData(url, method, destination)
{
    const data = new FormData($(".dataForm")[0]);
    fetch(url, {
        method : method,
        body : data
    })
        .then(response => response.json() )
            .then(result => {
                // jika obj result dari result pada parameter bernilai true
                if(result.result)
                {
                    $("body").load(destination);
                    let stateObj = { id: "100" };
                    window.history.replaceState(stateObj, "Page Website", destination);
                }
                else // jika bernilai false, maka terjadi error
                {
                    // datar value attribute name pada input..
                    const name_input = ["banner", "title", "desc", "due_date"];
                    name_input.map( name => { // lalu kita map
                        // kita spread key dari obeject result.error, dan kita masukan ke dalam array
                        // jika name pada nama_input ada pada obj result.error
                        if( [...Object.keys(result.error)].indexOf(name) !== -1) {
                            $(`input[name='${name}']`).addClass("is-invalid"); // tambahkan class is-invalid
                        } else { // jika tidak ada / bernilai -1, 
                            $(`input[name='${name}']`).removeClass("is-invalid"); // hapus class is-invalid
                        }
                    } );
                }
            })
            .catch(err => {
                $("body").load(`${url}`);
                $(".alert.alert-danger").removeClass("d-none");   
            });
}

function clickPaginate(el)
{
    const page = $(el).data("page");
    const final_url = `http://localhost:8080?page_tdl=${page}`;
    $("body").load(final_url);

    const stateObj = {id : "100"};
    window.history.replaceState(stateObj, "pagination", final_url);
}

function showTdl(e)
{
    const url = "http://localhost:8080";

    const slug = $(e).data("tdl");
    $("body").load(`${url}/show/detail/${slug}`);
    $("title").html("Detail Jadwal"); 

    let stateObj = { id: "100" };
    window.history.replaceState(stateObj, "Page", `${url}/show/detail/${slug}`);
}

function addRow(el)
{
    let el_tambahan = ``;
    let length = $("input[name='row']").length;
    let row = parseInt( $("input[name='row']")[length-1].value );

    // jika row/jumlah form (sebelum dipencet tombol nya) adalah genap 
    if(row % 2) 
    {
        el_tambahan += 
        `
        <hr>
        <form class="user dataForm col-lg-6" enctype="multipart/form-data" method="POST" action="#">
            <input type="hidden" name="row" value="${1 + row}">
            <div class="form-group">
                <label for="banner">Gambar Tugas</label>
                <input id="banner" type="file" class="form-control" id="validationServer03" aria-describedby="bannerValidate" name="banner" onchange="previewImage(this)">
                <div id="bannerValidate" class="invalid-feedback d-none">
                    
                </div>
                <img src="http://localhost:8080/banners/default.svg" alt="image preview" class="m-4 img-preview" width="200px">
            </div>
            <div class="form-group">
                <label for="title">Nama Jadwal</label>
                <input  name="title" id="title" type="text" class="form-control form-control-user" placeholder="MASUKAN NAMA JADWAL" >
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Jadwal</label>
                <textarea name="desc" id="description" cols="30" rows="10" class="form-control" ></textarea>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline Tugas / Jadwal</label>
                <input name="due_date" id="deadline" type="date" class="form-control" >
            </div>
        </form>
        `;
        // tambahkan el diatas setelah el yang memiliki class dataForm dengan index row-1, intinya akan dikasih di sebelahnya
        $( $(".dataForm")[row-1] ).after(el_tambahan);
    }
    else
    {
        el_tambahan += 
        `
            <div class="d-lg-flex justify-content-between">
                <form class="user dataForm col-lg-6" enctype="multipart/form-data" method="POST" action="#">
                    <input type="hidden" name="row" value="${1 + row}" class="rowCount">
                    <div class="form-group">
                        <label for="banner">Gambar Tugas</label>
                        <input id="banner" type="file" class="form-control" id="validationServer03" aria-describedby="bannerValidate" name="banner" onchange="previewImage(this)">
                        <div id="bannerValidate" class="invalid-feedback d-none">
                            
                        </div>
                        <img src="http://localhost:8080/banners/default.svg" alt="image preview" class="m-4 img-preview" width="200px">
                    </div>
                    <div class="form-group">
                        <label for="title">Nama Jadwal</label>
                        <input  name="title" id="title" type="text" class="form-control form-control-user" placeholder="MASUKAN NAMA JADWAL" >
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Jadwal</label>
                        <textarea name="desc" id="description" cols="30" rows="10" class="form-control" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Deadline Tugas / Jadwal</label>
                        <input name="due_date" id="deadline" type="date" class="form-control" >
                    </div>
                </form>
            </div>
        `;
        
        // cari el yang mempunyai class d-lg-flex
        const el_div_flex = $(".d-lg-flex");
        // cari last el yang mempunyai class d-lg-flex
        const last = el_div_flex.length - 1;
        // tambahkan el diatas setelah el d-flex terakhir
        $(el_div_flex[last]).after(el_tambahan);
    }

    // scroll to bottom page
    window.scrollTo(0,document.body.scrollHeight);
}

function toHome()
{
    $("body").load("http://localhost:8080");

    let stateObj = { id: "100" };
    window.history.replaceState(stateObj, "Home", "http://localhost:8080");
}

async function loopForm(formTdl, url)
{
    return await [...formTdl].map( async el => {
        const data = new FormData(el);
        return await fetch(`${url}/todolist/store`, {
            method: "POST",
            body: data
        })
            .then(response => response.json())
            .then(result => {

                // jika property dari obj param result bernilai true
                if (result.result) 
                {
                    setTimeout( () => {
                        $(el).html(
                            `
                                <div class="alert alert-success" role="alert">
                                    Berhasil Menambahkan Form
                                </div>
                            `
                        )}, 500);
                }
                else 
                {
                    const name_input = ["banner", "title", "desc", "due_date"];
                    name_input.map(name => {
                        // kita spread key dari obeject result.error, dan kita masukan ke dalam array
                        // jika name pada nama_input ada pada obj result.error
                        const type_input = name != "desc" ? "input" : "textarea";

                        if ([...Object.keys(result.error)].indexOf(name) !== -1) {
                            // tambahkan class is-invalid
                            $(el).find(`${type_input}[name='${name}']`).addClass("is-invalid");
                        } else {
                            // hapus class is-invalid
                            $(el).find(`${type_input}[name='${name}']`).removeClass("is-invalid");
                        }
                    });
                }
                return result.result;
            });
    });
}


$(document).ready(function ()
{
    const url = "http://localhost:8080";


    // ketika kelas create button di klik, maka :
    $(".create-button").on("click", () => {
        $("body").load(`${url}/buat/todolist`); // load halaman dengan url disamping
        $("title").html("Buat jadwal"); // ganti title website
        // lalu ubah url nya
        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Buat Jadwal", `${url}/buat/todolist`);
    });


    // ketika class update-tdl di klik, maka :
    $(".update-tdl").on( "click", e => {
        const slug = $(e.target).data("tdl")
        
        $("body").load(`${url}/sunting/${slug}/todolist`);
        $("title").html("Sunting Jadwal"); // ganti title website
        // lalu ubah url nya
        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Sunting Jadwal", `${url}/sunting/${slug}/todolist`);
    } );


    // ketika kelas back-tom (back to home) button di klik, maka :
    $(".back-tom").on("click", e => {
        // jika attribut data bernama backto ada mempunyai value/tidak kosong pada el e, maka isikan value tersebut, jika tidak ada maka isi dengan url
        const url_final = $(e.target).data("backto") ? $(e.target).data("backto") : url;
        // jika url_final diatas sama dengan url, maka title nya diganti home, jika tidak maka detail jadwal
        const title_website = url_final === url ? "Home" : "Detail Jadwal";
        
        $("body").load(`${url_final}`); // load halaman dengan url disamping
        $("title").html(title_website); // ganti title website
        // lalu ubah url nya
        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Page Website", `${url_final}`);
    });


    // ketika kelas delete-tdl ditekan, maka :
    $(".delete-tdl").on( "click", e => {
        // ambil attribute data bernama tdl dari element e.target, masukan ke dalam var slug
        const slug = $(e.target).data("tdl");
        
        fetch(`${url}/todolist/delete/${slug}`, {
            method : "DELETE",
        })
            .then(response => {
                // jika status code nya 200 / tidak error / berhasil
                if(response.status === 200)
                {
                    $("title").html("Home"); 
                    $("body").load(`${url}`); // load halaman home
                    window.scrollTo(top); // pindah ke bagian atas
                }
                else // jika terjadi error pada backend nya, sehingga menyebabkan status code !== 200
                {
                    window.scrollTo(top); // pindah ke bagian atas
                    $(".alert.alert-danger").removeClass("d-none"); // lalu hapus class d-none dari alert danger
                }
            } )

            .catch(err => {
                window.scrollTo(top); // pindah ke bagian atas
                $(".alert.alert-danger").removeClass("d-none");
            });        
    } );


    // jika ada form di submit
    $("form").on("submit", e => {
        // hilangkan/cegah aksi default nya
        e.preventDefault();
    });


    // jika el dengan class submit ditekan, 
    $(".submit").on("click", async () => {
        const formTdl =  $(".dataForm");
        
        // * jika ditekan tombolnya, animasi loading akan langsung keluar
        $(".loadingGif").removeClass("d-none");

        // ! panggil fungsi loopForm dengan keyword await, karena hasil return fungsi loopForm adalah promise maka kita bisa menggunakan method then agar hasil/return valuenya bisa diproses
        const result = await loopForm(formTdl, url).then(result1 => {
            /* 
                * 1. disini result1 bernilai array, yang isinya adalah obj promise, jika kita ingin mengambil semua value nya, maka dibutuhkan method all,
                * 2. karena masih berbentuk obj promise, maka kita masih dapat menggunakan method then, disini kita akan membungkus array hasil dari obj promise result1 ke dalam promise lagi, tetapi dengan format 1 promise yang membungkus array,
                * 3. karena masih berbentuk promise, kita masih dapat menggunakan method then. Lalu value dari result2 adalah array yang berasal dari value obj promise dari result1.
            */
            Promise.all(result1)
                .then( response => response.map(response => response) )
                .then(result2 => {
                    $(".loadingGif").addClass("d-none");
                    if( result2.indexOf(false) === -1 )
                    {
                        $("body").load(`${url}`);
                        let stateObj = { id: "100" };
                        window.history.replaceState(stateObj, "Page Website", `${url}`);

                        window.scrollTo(top); 
                    }
                } );
        } );
    });

    // update data tdl
    $(".update").on( "click", e => {
        const slug = $(e.target).data("tdl");
        fetchData(`${url}/todolist/update/${slug}`, "POST", `${url}/show/detail/${slug}`);
    } );


    // search data tdl
    $(".searchInput").on( "keyup", function() {
        fetch(`${url}/search/todolist/${$(this).val()}`, {
            method : "POST",
        })
        .then(response => response.json() )
            .then(result => $(".dataTdl").html(result.result) )
            .catch(result => console.log(result))
    } )


    // ke halaman profile
    $(".profileButton").on( "click", () => {
        $("body").load(`${url}/profile`);

        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Profile User", `${url}/profile`);
    } );


    // update profile
    $(".updateProfile").on( "click", () => {
        let data = new FormData( $("form.profileForm")[0] );
        
        fetch(`${url}/profile/update`, {
            method : "POST",
            body : data
        })
        .then(response => response.json() )
            .then( result => {
                if(result.result)
                {
                    $("body").load(`${url}/profile`);
                    window.scrollTo(top); 
                }
                else
                {
                    const field_error = [...Object.keys(result.error)];
                    const fields = ["image", "fullname", "username", "email", "password"];
                    fields.map( field => {
                        if( field_error.indexOf(field) !== -1 )
                        {
                            $(`input[name='${field}']`).addClass("is-invalid");
                        }
                        else
                        {
                            $(`input[name='${field}']`).removeClass("is-invalid");
                        }
                    } );
                }
            } )
            .catch(err => {
                $("body").load(`${url}`);
                $(".alert.alert-danger").removeClass("d-none");
                let stateObj = { id: "100" };
                window.history.replaceState(stateObj, "Home", `${url}`);
            } );
    } );

});



