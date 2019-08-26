<template>
    <div>
        <h3 class="text-center">All Books</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Sifra</th>
                <th>Naziv</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="zaliha in skladiste" :key="skladiste.id">
                <td>{{ zaliha.id }}</td>
                <td>{{ zaliha.Sifra }}</td>
                <td>{{ zaliha.NazivMaterijala }}</td>
                <td>{{ zaliha.created_at }}</td>
                <td>{{ zaliha.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <!--router-link :to="{name: 'edit', params: { id: zaliha.Id }}" class="btn btn-primary">Edit
                        </router-link-->
                        <button class="btn btn-primary" @click="editItem(zaliha)">Uredi</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "Skladiste",
        data() {
            return {
                skladiste: []
            }
        },
        created() {
            this.axios
                .get('/api/skladistes')
                .then(response => {
                    this.skladiste = response.data;
                });
        },
        methods: {
            editItem(zaliha) {
                console.log(zaliha);
                this.$router.push({name: 'skladisteDodaj',
                    params: {
                        Skladiste: zaliha,
                    }
                })
            },
            deleteItem(id) {
                console.log(id);
                this.axios
                    .delete(`/api/skladiste/destroy/${id}`)
                    .then(response => {
                        console.log(response);
                        let i = this.skladiste.map(item => item.id).indexOf(id); // find index of your object
                        this.skladiste.splice(i, 1)
                    });
            }
        }
    }
</script>

<style scoped>

</style>