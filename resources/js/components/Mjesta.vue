<template>
    <div>
        <h3 class="text-center">All Books</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Adresa</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody v-for="mjesto in mjesta" :key="mjesta.id">
            <tr >
                <td>{{ mjesto.id }}</td>
                <td>{{ mjesto.NazivMjesta }}</td>
                <td>{{ mjesto.Adresa }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button @click="switchDetails(mjesto.id)" class="btn btn-secondary" type="button" aria-expanded="false"  >
                            Termini
                        </button>
                        <button class="btn btn-primary" @click="editItem(mjesto)">Uredi</button>
                    </div>
                </td>
            </tr>
            <tr >
                <table style="all: unset;" v-show="datumi.length > 0 && datumi[0].Id_Mjesta == mjesto.id" :id="'DetailsCollapse'+mjesto.id" :ref="'DetailsCollapse'+mjesto.id" class=" collapse table table-bordered">
                    <thead>
                    <tr>
                        <th>Termin</th>
                    </tr>
                    </thead>
                    <tbody v-if="datumi.length > 0 && datumi[0].Id_Mjesta == mjesto.id">
                    <tr v-for="datum in datumi" :key="datumi.id">
                        <td>{{ datum.Datum }}</td>
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
        name: "Mjesta",
        data() {
            return {
                mjesta: [],
                datumi: []
            }
        },
        created() {
            this.axios
                .get('/api/mjestas')
                .then(response => {
                    this.mjesta = response.data;
                });
        },
        methods: {
            editItem(mjesto) {
                console.log(mjesto);
                this.$router.push({name: 'mjestaDodaj',
                    params: {
                        Mjesto: mjesto,
                    }
                })
            },
            switchDetails(id){
                if(this.datumi.length != 0){
                    if(this.datumi[0].Id_Mjesta == id){
                        this.datumi = [];
                    }else{
                        this.getDatumi(id)
                    }
                }else{
                    this.getDatumi(id)
                }
            },
            getDatumi(id){
                this.datumi = [];
                this.axios
                    .get(`/api/kalendar/master_all/${id}`)
                    .then(response => {
                        console.log(response.data);
                        this.datumi = response.data;
                        this.$refs["DetailsCollapse"+id][0]["attributes"][2].value = "collapse table table-bordered show";
                    });

            }
        }
    }
</script>

<style scoped>

</style>