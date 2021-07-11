function previewImage()
{
  const inputImage = document.querySelector("#banner");
  const image = new FileReader();
  image.readAsDataURL(inputImage.files[0]);
  image.onload = e => { // saat image sudah di load, maka :
    $(".img-preview").attr("src", e.target.result);  // ganti value atribut src pada image
  };
}

function fetchData(url, method)
{
    fetch(`http://localhost:8080/todolist/store`, {
        method : method,
        credentials : "same-origin",
        mode : "cors",
        body : new FormData($("#dataForm")[0])
    })
        .then(response => console.log(response.json()))
        .catch(err => {
            console.log(err);    
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
    $(".back-tom").on("click", () => {
        $("body").load(`${url}`); // load halaman dengan url disamping
        $("title").html("Home"); // ganti title website
        // lalu ubah url nya
        let stateObj = { id: "100" };
        window.history.replaceState(stateObj, "Home", `${url}`);
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


    // dibawah adalah action daripada url tambah data

    // jika ada form di submit
    $("form").on("submit", e => {
        // hilangkan/cegah aksi default nya
        e.preventDefault();
    });

    // jika el dengan class submit ditekan, 
    $(".submit").on("click", () => {
        let data = new FormData($("#dataForm")[0]);
        fetch(`${url}/todolist/store`, {
            method : "POST",
            body : data
        })
            .then(response => response.json() )

            .then(result => {
                // jika obj result dari result pada parameter bernilai true
                if(result.result)
                {
                    // load halaman home
                    $("body").load(`${url}`)
                    // lalu ubah url nya
                    let stateObj = { id: "100" };
                    window.history.replaceState(stateObj, "Home", `${url}`);
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
                $("body").load(`${url}/buat/todolist`);
                $(".alert.alert-danger").removeClass("d-none");   
            });
    });

    $(".update").on( "click", e => {
        // data.set("banner", $("#banner")[0]);
        // let data_obj = {};
        // for (const [key, value] of data.entries()) {
        //     data_obj[key] = value;
        // }
        const slug = $(e.target).data("tdl");
        let data = new FormData($("#dataForm")[0]);

        fetch(`${url}/todolist/update/${slug}`, {
            method : "POST",
            body : data
        })
            .then(response => response.json() )

            .then(result => {
                // jika obj result dari result pada parameter bernilai true
                if(result.result)
                {
                    $("body").load(`${url}/sunting/${slug}/todolist`)
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
                // $("body").load(`${url}/buat/todolist`);
                $(".alert.alert-danger").removeClass("d-none");   
            });
    } );
});



