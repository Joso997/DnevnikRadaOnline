<template>
    <div>
        <h3 class="text-center">Sva Mjesta</h3><br/>

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
                        <button v-if="mjesto.hasDetails" @click="switchDetails(mjesto.id)" class="btn btn-secondary" type="button" aria-expanded="false"  >
                            Termini
                        </button>
                        <button class="btn btn-primary" @click="editItem(mjesto)">Uredi</button>
                    </div>
                </td>
            </tr>
            <div class="modal fade" :id="'DetailsCollapse'+mjesto.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Termini</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" v-if="datumi.length > 0 && datumi[0].Id_Mjesta == mjesto.id">
                            <ul class="list-group" v-for="datum in datumi" :key="datumi.id">
                                <li class="list-group-item"><b>Datum:</b> {{ datum.Datum }}</li>
                            </ul>
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
                this.getDatumi(id)
            },
            getDatumi(id){
                this.axios
                    .get(`/api/kalendar/master_all/${id}`)
                    .then(response => {
                        console.log(response.data);
                        this.datumi = response.data;
                        $('#DetailsCollapse'+id).modal('toggle');
                    });

            }
        }
    }
</script>

<style scoped>

</style>