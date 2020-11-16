<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div id="app">
        <div class="container my-3">
            <div class="col-md-8">
                <div class="form-group">
                    <input type="email" class="form-control" v-model='email' placeholder="email@email.com">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" v-model='password' placeholder="My Password">
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-2">
                        <button class="btn btn-outline-dark" v-on:click='addUser'>add user</button>
                    </div>
                    <div class="col-10">
                        <div :class='{"alert alert-success": message}'>@{{message}}
                        </div>
                    </div>
                </div>
                
                <hr>
                    
                <ul class="list-group" v-for='(user, index) in users'>
                    <li class="list-group-item">@{{user.email}} | <span class="badge" :class='{"badge-success": user.email_verified_at, "badge-danger": !user.email_verified_at}'>@{{user.email_verified_at ? 'verified' : 'unverified'}}</span> 
                        <button class="btn btn-sm btn-outline-danger px-2 ml-4" v-on:click='removeUser(user, index)'>X</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/axios"></script>
    <script src="https://unpkg.com/vue"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                email: '',
                password: '',
                message: '',
                users: []
            },
            mounted: function() {
                axios.get('/api/users')
                .then(response => {
                    // console.log(response.data.data)
                    this.users = response.data.data
                })
            },
            methods: {
                addUser: function() {
                    let userData = {
                        email: this.email,
                        password: this.password
                    }
                    axios.post('/api/auth/register', userData)
                    .then(response => {
                        // console.log(response.data.data)
                        let userRegistered = response.data.data.user
                        this.users.unshift(userRegistered)
                        this.message = response.data.response_message
                    })
                },
                removeUser: function(user, index) {
                    this.users.splice(index, 1)
                    axios.delete(`/api/users/delete/${user.id}`)
                    .then(response => {
                        this.message = response.data.response_message
                    })
                }
            }
        })
    </script>
</body>
</html>