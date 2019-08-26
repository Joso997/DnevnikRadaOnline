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
                        <button @click="switchDetails(evidencija.id)" class="btn btn-secondary" type="button" aria-expanded="false"  >
                            Materijali
                        </button>
                    </div>
                </td>
            </tr>
            <tr >
                <table style="all: unset;" v-show="poveznice.length > 0 && poveznice[0].Id_Evidencija == evidencija.id" :id="'DetailsCollapse'+evidencija.id" :ref="'DetailsCollapse'+evidencija.id" class=" collapse table table-bordered">
                    <thead>
                    <tr>
                        <th>Sifra</th>
                        <th>Naziv Materijala</th>
                        <th>Kolicina</th>
                    </tr>
                    </thead>
                    <tbody v-if="poveznice.length > 0 && poveznice[0].Id_Evidencija == evidencija.id">
                        <tr v-for="poveznica in poveznice" :key="poveznice.id">
                            <td>{{ poveznica.Sifra }}</td>
                            <td>{{ poveznica.Skladiste.NazivMaterijala }}</td>
                            <td>{{ poveznica.Kolicina }}</td>
                        </tr>
                    </tbody>
                </table>
            </tr>
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
                        this.$refs["DetailsCollapse"+id][0]["attributes"][2].value = "collapse table table-bordered show";
                    });
            }
        },
    }
</script>

<style scoped>

</style>