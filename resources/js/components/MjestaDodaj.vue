<template>
    <div>
        <h3 class="text-center">Add Book</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group">
                        <label>Naziv Mjesta</label>
                        <input type="text" class="form-control" v-model="input.NazivMjesta">
                    </div>
                    <div class="form-group">
                        <label>Adresa</label>
                        <input type="text" class="form-control" v-model="input.Adresa">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
            <div class="col-md-6">
                <label>&nbsp</label>
                <form @submit.prevent="addTermin">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Termin</span>
                        </div>
                         <datepicker :disabled-dates="state.disabledDates" :placeholder="( d => new Date(d.setDate(d.getDate()-1)) )(new Date).toDateString()" :bootstrap-styling="true" type="text" v-model="datum.Datum"></datepicker>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" id="button-addon2">Dodaj</button>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li v-for="_datum in datumi" :key="_datum.id" class="list-group-item clearfix">
                            {{_datum.Datum}}
                            <button class="btn btn-danger float-right" type="button" @click="removeTermin(_datum.Datum)">Remove</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    export default {
        name: "MjestaDodaj",
        props: [
            'Mjesto',
        ],
        components: {
            Datepicker
        },
        created() {
            if(this.Mjesto != null){
                this.input = this.Mjesto;
                console.log(this.input);
                this.axios
                    .get(`/api/kalendar/master_all/${this.Mjesto.id}`)
                    .then(response => {
                        //console.log(response.data);
                        this.datumi = response.data;
                    });
            }
        },
        data() {
            return {
                input: {},
                datumi: [],
                datum: {},
                state : {
                    disabledDates: {
                        //from: ( d => new Date(d.setDate(d.getDate()-1)) )(new Date)
                        to: new Date()
                    }
                }
            }
        },
        methods: {
            addItem() {
                if (this.datumi.length == 0) {
                    this.input.hasDetails = false;
                }else{
                    this.input.hasDetails = true;
                }
                if(this.Mjesto == null) {
                    this.axios
                        .post('/api/mjesta/store', this.input)
                        .then(response => {
                            if (this.datumi.length == 0) {
                                this.input.hasDetails = false;
                                this.$router.push({name: 'mjesta'})
                            } else {
                                this.input.hasDetails = true;
                                this.addDetails(response.data.last_insert_id);
                            }
                        })
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
                }else{
                    this.axios
                        .post(`/api/mjesta/update/${this.input.id}`, this.input)
                        .then(response => {
                            console.log(response.data.last_insert_id);
                            this.editDetails(response.data.last_insert_id);
                        })
                        .catch(error => { console.log(error);})
                        .finally(() => this.loading = false)
                }
            },
            addDetails(mjesto_id){
                let details = {Id_Mjesta: mjesto_id, datumi: this.datumi};
                this.axios
                    .post('/api/kalendar/store', details)
                    .then(response => {
                        this.$router.push({name: 'mjesta'});
                        console.log(response.data);
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            editDetails(mjesto_id){
                let details = {Id_Mjesta: mjesto_id, datumi: this.datumi};
                this.axios
                    .post(`/api/kalendar/store/`, details)
                    .then(response => {
                        this.$router.push({name: 'mjesta'});
                        console.log(response.data);
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            addTermin(){
                this.datum.Datum = moment(this.datum.Datum).format('Y-MM-DD');
                if(this.datumi.length == 0){
                    this.datumi.push(this.datum);
                }
                else{
                    for(var i = 0; i < this.datumi.length;i++){
                        //console.log(this.datumi[i].termin == this.datum.termin);
                        if(this.datumi[i].Datum == this.datum.Datum){
                            break;
                        }else if(i == this.datumi.length-1){
                            this.datumi.push(this.datum);
                            break;
                        }
                    }
                }
                this.datum = {};
            },
            removeTermin(id){
                for(var i = 0; i < this.datumi.length;i++){
                    if(this.datumi[i].Datum == id){
                        this.datumi.splice(this.datumi[i],1);
                        break;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>