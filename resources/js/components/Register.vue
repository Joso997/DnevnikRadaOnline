<template>
    <div class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
        <form action="#" @submit.prevent="register()">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                <div class="col-md-6">
                    <input placeholder="Minimalno 4 znaka" type="text" id="name" pattern=".{4,}" class="form-control" name="email-address" required autofocus v-model="input.name">
                </div>
            </div>

            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                <div class="col-md-6">
                    <input placeholder="primjer@primjer.com" type="email" id="email_address" class="form-control" name="email-address" required autofocus v-model="input.email">
                </div>
            </div>

            <div class="form-group row">
                <label for="password1" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                    <input placeholder="Minimalno 8 znakova" type="password" pattern=".{8,}" id="password1" class="form-control" name="password" required v-model="input.password">
                </div>
            </div>

            <div class="form-group row">
                <!--div class="col-md-6 offset-md-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div-->

            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
                <!--a href="#" class="btn btn-link">
                    Forgot Your Password?
                </a-->
            </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
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
        created() {
            if(this.$cookie.get('loginToken') != null){
                this.$router.push({name: 'home'});
            }
        },
        methods: {
            register(){
                this.axios
                    .post('/api/register', this.input)
                    .then(response => {
                        this.$router.push({name: 'login'});
                        Vue.$toast.open({
                            message: 'Registracija je Uspješno Izvršena',
                            type: 'success',
                            position: 'top'
                        });
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>