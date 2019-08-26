<template>
    <div class="login-form">
        <h2 class="login-heading">Login</h2>
        <form action="#" @submit.prevent="login">
            <div class="form-control">
                <label for="email">Username/Email</label>
                <input type="email" name="username" id="username" class="login-input" v-model="input.username">
            </div>

            <div class="form-control mb-more">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="login-input" v-model="input.password">
            </div>

            <div class="form-control">
                <button type="submit" class="btn-submit">Login</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data(){
            return{
                input: {},
            }
        },
        created() {
            this.axios
                .get('/api/skladistes')
                .then(response => {
                    this.skladiste = response.data;
                });
        },
        methods:{
            login(){
                this.axios
                    .post('/api/login', this.input)
                    .then(response => {
                        this.$parent.$emit('ChangeView', 'someValue');
                        this.$cookie.set('loginToken',response.data['access_token']);
                        this.$router.push({name: 'home'});

                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>