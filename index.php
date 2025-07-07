<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>php form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="container-xl">
            <form class="row g-3" id="form" method="post">
                <div class="result" id="result"></div>
                <div class="col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" onkeyup="validateName()" placeholder="Enter full name" required>
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" onkeyup="validateEmail()" placeholder="Enter email" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input value="male" name="gender" class="form-check-input" type="radio" id="radio" required>
                        <label class="form-check-label" for="radio">
                            male
                        </label>
                    </div>
                    <div class="form-check">
                        <input value="female" name="gender" class="form-check-input" type="radio" id="radio" required>
                        <label class="form-check-label" for="radio">
                            female
                        </label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="state" class="form-label">State</label>
                    <select id="state" name="state" class="form-select" required>
                        <option selected>Choose...</option>
                        <option value="california">California</option>
                        <option value="new york">new york</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" name="city" id="city" required onkeyup="validateCity()" placeholder="Enter city">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" value="yes" type="checkbox" name="check" onclick="validateCheck()" id="check" >
                        <label class="form-check-label" for="check">
                            Check me out
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" id="submit" name="submit" value="submit"  class="btn btn-primary" disabled>insert</button>
                </div>
                <div class="col-3 text-align-center">
                   <a href="view.php"> <button type="button"    class="btn btn-primary mx-auto">view data</button></a>
                </div>
            </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
        form.onsubmit = async (e)=>{
            e.preventDefault()
            let formdata = new FormData(form);
            formdata.append('submit','submit')
            let response = await fetch('form.php', {
                method: 'POST',
                body: formdata
            })
            let result = await response.text()
            document.getElementById('result').innerHTML = result;
            if(!result){
                window.location.href = "view.php"

            }


        }

        function validateName() {
            let name = document.getElementById('name').value
            let btn = document.getElementById('submit');
            let msg = ''
            if (name == "") {
                msg = 'Name can not be empty'
                btn.disabled = true;
            } 
        
            document.getElementById('result').innerHTML = msg
        }
        function validateEmail(){
            let email = document.getElementById('email').value
            let btn = document.getElementById('submit');
            let msg =''
             if (email = "" || !email.includes('@') || !email.includes('.')) {
                msg = "Invalid emaill"
                btn.disabled = true;
            }
        
            document.getElementById('result').innerHTML = msg
        }
        function validateCity(){
            let city = document.getElementById('city').value
            let btn = document.getElementById('submit');
            let msg = ''
            if (city = "") {
                msg = "city can not be empty"
                btn.disabled = true;
            }
           
            document.getElementById('result').innerHTML = msg
        }
        function validateCheck(){
            let check = document.getElementById('check')
            let btn = document.getElementById('submit');
            let msg =''
            if (!check.checked) {
                btn.disabled = true;
            }
            else{
                btn.disabled = false;
            }
            document.getElementById('result').innerHTML = msg
        }
    </script>
</body>

</html>