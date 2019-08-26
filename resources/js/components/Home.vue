<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="container-fluid">
                    <div class="row" style="height: 12em;">
                        <div class="col-md-7">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'evidencija'})">Evidencija Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'evidencijaDodaj'})">Evidencija Dodaj</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'statistika'})">Statistika</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="height: 12em; padding-top: 1em;">
                        <div class="col-md-6">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'skladiste'})">Skladište Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'skladisteDodaj'})">Skladište Dodaj</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group btn-group-lg d-flex align-items-stretch h-100" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'mjesta'})">Mjesta Traži</button>
                                <button type="button" class="btn btn-secondary" @click="$router.push({name: 'mjestaDodaj'})">Mjesta Dodaj</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <datepicker :disabled="true" @changedMonth="getDatumi" :highlighted="currentDate.highlighted" :inline="true"></datepicker>
                <div class="list-group">
                    <li class="list-group-item active">Termini</li>
                    <li v-for="termin in kalendar.termini" :key="termin.id" class="text-center list-group-item list-group-item-light">
                        {{termin.NazivMjesta}}
                        {{termin.Datum}}
                    </li>
                </div>
                <div class="list-group">
                    <li class="list-group-item active">Obavijesti</li>
                    <button v-for="obavijest in kalendar.obavijesti" :key="obavijest.id" @click="onObavijestClick(obavijest.Id_Mjesta,obavijest.Datum)" type="button" class="text-center list-group-item list-group-item-action list-group-item-info">
                        {{obavijest.NazivMjesta}}
                        {{obavijest.Datum}}
                    </button>
                </div>
            </div>
        </div>
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
            }
        }
    }

</script>

<style scoped>

</style>