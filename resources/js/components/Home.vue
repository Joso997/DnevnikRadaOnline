<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="container-fluid">
                    <div class="row" style="height: 12em; margin-bottom: 3em;">
                        <div class="col-md-7">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary " @click="$router.push({name: 'evidencija'})"><img class='img-fluid w-100' src="/Ikone/Search.svg" alt="icon name">Evidencija Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'evidencijaDodaj'})"><img class='img-fluid w-100' src="/Ikone/Add.svg" alt="icon name">Evidencija Dodaj</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'statistika'})"><img class='img-fluid w-50' src="/Ikone/Stats.svg" alt="icon name">Statistika</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="height: 12em; padding-top: 1em;">
                        <div class="col-md-6">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'skladiste'})"><img class='img-fluid w-100' src="/Ikone/Search.svg" alt="icon name">Skladište Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'skladisteDodaj'})"><img class='img-fluid w-100' src="/Ikone/Add.svg" alt="icon name">Skladište Dodaj</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'mjesta'})"><img class='img-fluid w-100' src="/Ikone/Search.svg" alt="icon name">Mjesta Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'mjestaDodaj'})"><img class='img-fluid w-100' src="/Ikone/Add.svg" alt="icon name">Mjesta Dodaj</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <datepicker :disabled="true" @changedMonth="getDatumi" :highlighted="currentDate.highlighted" :inline="true"></datepicker>
                <div class="list-group" >
                    <li class="list-group-item active">Termini</li>
                    <li v-for="termin in kalendar.termini" :key="termin.id" class="text-center list-group-item list-group-item-light">
                        {{termin.NazivMjesta}}
                        {{termin.Datum}}
                    </li>
                </div>
                <div class="list-group">
                    <li class="list-group-item active" >Obavijesti</li>
                    <button v-for="obavijest in kalendar.obavijesti" :key="obavijest.id" @click="onObavijestClick(obavijest.Id_Mjesta,obavijest.Datum)" type="button" class="text-center list-group-item list-group-item-action list-group-item-info">
                        {{obavijest.NazivMjesta}}
                        {{obavijest.Datum}}
                    </button>
                </div>
            </div>
        </div>
        <footer class="page-footer font-small blue mt-3">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3"><p class="text-secondary">Ulogirani Korisnik:</p> <p class="text-info font-weight-bold">{{CurrentUser}}</p></div>
            <!-- Copyright -->

        </footer>
    </div>


</template>

<script>
    import moment from 'moment'
    import Datepicker from 'vuejs-datepicker';
    export default {
        name: "Home",
        components: {
            Datepicker
        },
        data() {
            return {
                CurrentUser: {},
                kalendar: [],
                termini: [],
                obavijesti: [],
                currentDate: {
                    highlighted: {
                        dates: [
                            new Date()
                        ],
                    }
                },
            }
        },
        created() {
            this.axios.defaults.headers.common['Authorization'] = "Bearer " + this.$cookie.get('loginToken');
            this.getDatumi(new Date().toDateString());
            this.getUser();
        },
        methods:{
            getDatumi(datum){
                datum = moment(datum).format('Y-MM-DD')
                this.axios
                    .get(`/api/kalendars/${datum}`)
                    .then(response => {
                        console.log(response.data);
                        this.kalendar = response.data;
                    });
                console.log(datum);
            },
            onObavijestClick(Id_Mjesta, Datum){
                this.$router.push({name: 'evidencijaDodaj',
                    params: {
                        Id_Mjesta: Id_Mjesta,
                        Datum: Datum
                    }
                })
            },
            getUser(){
                this.axios
                    .get('/api/user')
                    .then(response => {
                        this.CurrentUser =  response.data.name;
                    });
            }
        }
    }

</script>

<style scoped>

</style>