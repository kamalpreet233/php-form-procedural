<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="container">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">city</th>
                        <th scope="col">gender</th>
                        <th scope="col">state</th>
                        <th scope="col">actions</th>


                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
            <a href="index.php" ><button class="btn btn-primary" >Insert date</button></a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
        async function load() {

            let response = await fetch('form.php?req=' + encodeURIComponent('sel'))
            let result = await response.json()
            console.log(result)
            document.getElementById('tbody').innerHTML = ''
            result.forEach(function(result) {
                document.getElementById('tbody').innerHTML += `<tr>
                        <td>${result.id}</td>
                        <td>${result.name}</td>
                        <td>${result.email}</td>
                        <td>${result.city}</td>
                        <td>${result.gender}</td>
                        <td>${result.state}</td>
                        <td><button type="button" onclick="dlt(${result.id})">Delete</button>
                        <button type="button" onclick="update(${result.id})">update</button></td>
                        <form method="post" id="form_id">
                            <input type="hidden" name="id" value="${result.id}">
                        </form>

                    </tr>`
            });

        }
        load()
        async function dlt(id) {
            let form  = document.getElementById('form_id')
            let input = form.querySelector('input[name="id"]')
            
            let formdata  = new FormData(form);
            formdata.append('id',id)
            
            let response = await fetch('form.php?req=' + encodeURIComponent('dlt'), {
                method: "POST",
                body: formdata
            })
            let result  = await response.text()
            alert(result)
            load()
        }
        async function update(id) {
            let url = "edit.php?id=" + encodeURIComponent(id) 
            window.location.href = url;
           
        }
    </script>
</body>

</html>