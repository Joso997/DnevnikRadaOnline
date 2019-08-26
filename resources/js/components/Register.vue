<template>
    <div class="login-form">
        <h2 class="login-heading">Register</h2>
        <form action="#" @submit.prevent="register()">
            <div class="form-control">
                <label for="name">Name</label>
                <input type="name" name="name" id="name" class="login-input" v-model="input.name">
            </div>

            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="login-input" v-model="input.email">
            </div>

            <div class="form-control mb-more">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="login-input" v-model="input.password">
            </div>

            <div class="form-control">
                <button type="submit" class="btn-submit">Register</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data(){
            return{
                input: {}
            }
        },
        methods: {
            register(){
                this.axios
                    .post('/api/register', this.input)
                    .then(response => {
                        this.$parent.$emit('ChangeView', 'someValue');
                        this.$cookie.set('loginToken',response.data['access_token']);
                        this.$router.push({name: 'login'});
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>