<template>
    <div>
        <h3 class="text-center">All Books</h3><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sifra</th>
                <th>Mjesto Rada</th>
                <th>Datum</th>
                <th>Opis Posla</th>
                <th>Utroseno Vrijeme</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody v-for="evidencija in evidencije" :key="evidencije.id">
            <tr >
                <td>{{ evidencija.Sifra }}</td>
                <td>{{ evidencija.NazivMjesta }}</td>
                <td>{{ evidencija.Datum }}</td>
                <td>{{ evidencija.OpisPosla }}</td>
                <td>{{ evidencija.UtrosenoVrijeme }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button v-if="evidencija.hasDetails == 1" @click="switchDetails(evidencija.id)" class="btn btn-secondary" type="button" aria-expanded="false"  >
                            Materijali
                        </button>
                    </div>
                </td>
            </tr>
            <tr >
            </tr>
            <div class="modal fade" :id="'DetailsCollapse'+evidencija.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Termini</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" v-if="poveznice.length > 0 && poveznice[0].Id_Evidencija == evidencija.id">
                            <div v-for="poveznica in poveznice" :key="poveznice.id">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Naziv:</b> {{ poveznica.Skladiste.NazivMaterijala }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Šifra: {{ poveznica.Sifra }}</h6>
                                    <p class="card-text">Količina: {{ poveznica.Kolicina }}</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "Evidencija",
        data() {
            return {
                evidencije: [],
                poveznice: [],
            }
        },
        created() {
            this.axios
                .get('/api/evidencijas')
                .then(response => {
                    this.evidencije = response.data;
                });
        },
        methods: {
            switchDetails(id){
                if(this.poveznice.length != 0){
                    if(this.poveznice[0].Id_Evidencija == id){
                        this.poveznice = [];
                    }else{
                        this.getPoveznica(id)
                    }
                }else{
                    this.getPoveznica(id)
                }
            },
            getMjestoRada(){

            },
            getPoveznica(id){
                this.poveznice = [];
                this.axios
                    .get(`/api/poveznica/master_all/${id}`)
                    .then(response => {
                        this.poveznice = response.data;
                        $('#DetailsCollapse'+id).modal('toggle');
                        //this.$refs["DetailsCollapse"+id][0]["attributes"][2].value = "collapse table table-bordered show";
                    });
            }
        },
    }
</script>

<style scoped>

</style>