function previewImage()
{
  const inputImage = document.querySelector("#banner");
  const image = new FileReader();
  image.readAsDataURL(inputImage.files[0]);
  image.onload = e => { // saat image sudah di load, maka :
    $(".img-preview").attr("src", e.target.result);  // ganti value atribut src pada image
  };
}

function fetchData(url, method, destination)
{
    const data = new FormData($("#dataForm")[0]);
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
    $(".submit").on("click", () => {
        // panggil fungsi fetch data
        fetchData(`${url}/todolist/store`, "POST", `${url}`)
    });

    $(".show-tdl").on( "click", e => {
        const slug = $(e.target).data("tdl");
        $("body").load(`${url}/show/detail/${slug}`);
        $("title").html("Detail Jadwal"); 

        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Page", `${url}/show/detail/${slug}`);
    } )

    $(".update").on( "click", e => {
        const slug = $(e.target).data("tdl");
        // let data = new FormData($("#dataForm")[0]);
        fetchData(`${url}/todolist/update/${slug}`, "POST", `${url}/show/detail/${slug}`);
    } );

    $(".searchInput").on( "keyup", function() {
        fetch(`${url}/search/todolist/${$(this).val()}`, {
            method : "POST",
        })
        .then(response => response.json() )
            .then(result => $(".dataTdl").html(result.result) )
            .catch(result => console.log(result))
    } )
});



