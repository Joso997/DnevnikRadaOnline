<template>
    <div>
        <h3 class="text-center">Dodaj Materijal</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group">
                        <label>Sifra</label>
                        <input type="text" class="form-control" v-model="input.Sifra">
                    </div>
                    <div class="form-group">
                        <label>Naziv Materijala</label>
                        <input type="text" class="form-control" v-model="input.NazivMaterijala">
                    </div>
                    <div class="form-group">
                        <label>Prodavac</label>
                        <input type="text" class="form-control" v-model="input.Prodavac">
                    </div>
                    <div class="form-group">
                        <label>Kolicina</label>
                        <input type="text" class="form-control" v-model="input.Kolicina">
                    </div>
                    <div class="form-group">
                        <label>Mjerna Jedinica</label>
                        <input type="text" class="form-control" v-model="input.MjernaJedinica">
                    </div>
                    <div class="form-group">
                        <label>Cijena</label>
                        <input type="text" class="form-control" v-model="input.Cijena">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "SkladisteDodaj",
        props: [
            'Skladiste',
        ],
        created() {
            if(this.Skladiste != null){
                this.input = this.Skladiste;
                console.log(this.Skladiste);
            }
        },
        data() {
            return {
                input: {}
            }
        },
        methods: {
            addItem() {
                if(this.Skladiste == null) {
                    this.axios
                        .post('/api/skladiste/store', this.input)
                        .then(response => (
                            this.$router.push({name: 'skladiste'})

                        ))
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
                }else{
                    this.axios
                        .post(`/api/skladiste/update/${this.input.id}`, this.input)
                        .then(response => {
                            this.$router.push({name: 'skladiste'})
                        })
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
                }
            }
        }
    }
</script>

<style scoped>

</style>