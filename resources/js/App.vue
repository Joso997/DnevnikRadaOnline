<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="https://www.mynotepaper.com/" target="_blank"><img src="https://i.imgur.com/hHZjfUq.png"></a><br>
            <span class="text-secondary">Developed by Joso Marich</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <router-link v-if="loggedIn" to="/" class="nav-item nav-link">Home</router-link>
                    <router-link v-if="!loggedIn" to="/login" class="nav-item nav-link">Log In</router-link>
                    <router-link v-if="!loggedIn" to="/register" class="nav-item nav-link">Register</router-link>
                </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a v-if="loggedIn" type="button" @click="logoutUser" class="nav-item nav-link ml-auto">Log Out</a>
                        </li>
                </ul>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                loggedIn: {},
            }
        },
        created(){
            this.$on('ChangeView', section => {
                this.loggedIn = true;
            });
            if(this.$cookie.get('loginToken') != null){
                this.axios.defaults.headers.common['Authorization'] = "Bearer " + this.$cookie.get('loginToken');
                this.loggedIn = true;
            }
            else{
                this.loggedIn = false;
                this.$router.push({name: 'login'});
            }

        },
        methods: {
            logoutUser(){
                let config = {
                    headers: { Authorization: "Bearer " + this.$cookie.get('loginToken') }
                };
                let bodyParameters = {
                    key: "value"
                };
                this.axios
                    .post('/api/logout', bodyParameters, config)
                    .then(response => {
                        this.$cookie.delete('loginToken');
                        this.loggedIn = false;
                        this.$router.push({name: 'login'});
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false,
                        this.$cookie.delete('loginToken'),
                        this.$router.push({name: 'login'}))
            }
        }
    }
</script>