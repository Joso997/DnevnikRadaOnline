<template>
    <div>
        <h3 class="text-center">Dodaj Evidenciju</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group">
                        <label>Sifra</label>
                        <input type="text" class="form-control" v-model="input.Sifra">
                    </div>
                    <div class="form-group">
                        <label>Mjesto Rada</label>
                        <select  class="custom-select" v-model="input.Id_Mjesta">
                            <option v-if="Id_Mjesta == null" :value="input.Id_Mjesta" v-once selected>Odaberi...</option>
                            <option v-for="mjesto in mjesta" :key="mjesto.id" :value="mjesto.id">
                                {{ mjesto.NazivMjesta }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Datum</label>
                        <datepicker :disabled-dates="state.disabledDates" :placeholder="new Date().toDateString()" :bootstrap-styling="true" v-model="input.Datum"></datepicker>
                    </div>
                    <div class="form-group">
                        <label>Utroseno Vrijeme</label>
                        <input type="text" class="form-control" v-model="input.UtrosenoVrijeme">
                    </div>
                    <div class="form-group">
                        <label>Opis Posla</label>
                        <input type="text" class="form-control" v-model="input.OpisPosla">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
            <div class="col-md-6">
                <label>&nbsp</label>
                <form @submit.prevent="addMaterijal">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Materijal</span>
                        </div>
                        <select  class="custom-select" id="inputGroupSelectMaterijal" v-model="materijal.id">
                            <option :value="materijal.id" v-once selected>Odaberi...</option>
                            <option v-for="zaliha in skladiste" :key="zaliha.id" :value="zaliha.id" @click="selectMaterijal(zaliha.MjernaJedinica)" >
                                {{ zaliha.NazivMaterijala }}
                            </option>
                        </select>
                        <select class="custom-select" id="inputGroupSelectOperacija" v-model="operator">
                            <option value="0" selected>Odaberi...</option>
                            <option value="1">+</option>
                            <option value="-1">-</option>
                        </select>
                        <input type="text" aria-label="Last name" class="form-control" v-model="materijal.Kolicina">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ simbol }}</span>
                            <button type="submit" class="btn btn-outline-secondary" id="button-addon2">Dodaj</button>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li v-for="_materijal in materijali" :key="_materijal.id" class="list-group-item clearfix">
                            {{$el.querySelector('#inputGroupSelectMaterijal option[value="'+_materijal.id+'"]').text}}
                            {{_materijal.Kolicina}}
                            <button class="btn btn-danger float-right" type="button" @click="removeMaterijal(_materijal.id)">Remove</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        name: "EvidencijaDodaj",
        props: [
            'Id_Mjesta',
                'Datum'
        ],
        components: {
            Datepicker
        },
        data() {
            return {
                input: {},
                skladiste: [],
                mjesta: [],
                simbol: "_",
                materijali: [],
                materijal: {},
                operator: 0,
                state : {
                    disabledDates: {
                        from: new Date()
                    }
                }
            }
        },
        created() {
            this.axios
                .get('/api/skladistes')
                .then(response => {
                    this.skladiste = response.data;
                    //console.log(response.data)
                });
            this.axios
                .get('/api/mjestas')
                .then(response => {
                    this.mjesta = response.data;
                    //console.log(response.data)
                });
            this.input.Datum = this.Datum;
            this.input.Id_Mjesta = this.Id_Mjesta;
        },
        methods: {
            addItem() {
                console.log(this.input.Datum);
                if (this.materijali.length == 0) {
                    this.input.hasDetails = false;
                }else{
                    this.input.hasDetails = true;
                }
                this.axios
                    .post('/api/evidencija/store', this.input)
                    .then(response => {
                        if (this.materijali.length == 0) {
                            this.input.hasDetails = false;
                            this.$router.push({name: 'evidencija'});
                        } else {
                            this.input.hasDetails = true;
                            this.addDetails(response.data.last_insert_id);
                        }
                        console.log(response.data);
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            addDetails(evidencija_id){
                let details = {Id_Evidencija: evidencija_id, materijali: this.materijali};
                this.axios
                    .post('/api/poveznica/store', details)
                    .then(response => {
                        this.$router.push({name: 'evidencija'});
                        console.log(response.data);
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            selectMaterijal(_simbol){
                this.simbol = _simbol
            },
            resetMaterijal(){
                this.materijal.Kolicina *= this.operator;
                if(this.materijali.length == 0){
                    this.materijali.push(this.materijal);
                }
                else{
                    for(var i = 0; i < this.materijali.length;i++){
                        if(this.materijali[i].id == this.materijal.id){
                            this.materijali[i].Kolicina = this.materijal.Kolicina;
                            break;
                        }else if(i == this.materijali.length-1){
                            this.materijali.push(this.materijal);
                            break;
                        }
                    }
                }
                this.materijal = {};
                this.operator = 0;

            },
            addMaterijal(){
                if(this.operator == -1){
                    var id = this.materijal.id;
                    var kolicina = this.materijal.Kolicina;
                    this.axios
                        .get(`/api/skladiste/check/${id}/${kolicina}`)
                        .then(response => {
                            console.log(response.data);
                            if(response.data == true){
                                this.resetMaterijal();
                            }
                        }).catch(error => console.log(error))
                        .finally(() => this.loading = false);
                }else{
                    this.resetMaterijal();
                }
            },
            removeMaterijal(id){
                for(var i = 0; i < this.materijali.length;i++){
                    if(this.materijali[i].id == id){
                        this.materijali.splice(this.materijali[i],1);
                        break;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>