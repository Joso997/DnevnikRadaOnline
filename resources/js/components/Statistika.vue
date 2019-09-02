<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        Stanje Poduzeća
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        <graph-line
                                :width="600"
                                :height="400"
                                :shape="'normal'"
                                :axis-min="0"
                                :axis-max="50"
                                :axis-full-mode="true"
                                :labels="[ '1M', '2M', '3M', '4M', '5M', '6M', '7M', '8M' ]"
                                :names="grafovi.prvi.names"
                                :values="grafovi.prvi.values">
                            <note :text="'Line Chart'"></note>
                            <tooltip :names="grafovi.prvi.names" :position="'right'"></tooltip>
                            <legends :names="grafovi.prvi.names"></legends>
                            <guideline :tooltip-y="true"></guideline>
                        </graph-line>
                    </div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                        <graph-area-timerange
                                :width="600"
                                :height="400"
                                :axis-min="0"
                                :axis-max="100"
                                :axis-reverse="false"
                                :axis-format="'MM-dd'"
                                :axis-interval="1000 * 60 * 60 * 24 * 30"
                                :labels="grafovi.drugi.labels"
                                :values="grafovi.drugi.values">
                            <note :text="'Area Chart'"></note>
                            <guideline :tooltip-x="true" :tooltip-y="true"></guideline>
                        </graph-area-timerange>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        Stanje Poduzeća
                    </a>
                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                        Potrošnja Materijala Kroz Vrijeme
                    </a>
                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">
                        Broj Održavanja Kroz Vrijeme
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Statistika",
        data(){
            return{
                grafovi: {
                    prvi: {
                        names: [],
                        values: []
                    },
                    drugi: {
                        labels: [ new Date("2019-07-01"), new Date("2019-10-01") ],
                        values: [
                            [ new Date("2019-07-01"), 5 ],
                            [ new Date("2019-07-15"), 30 ],
                            [ new Date("2019-08-07"), 70 ],
                            [ new Date("2019-09-07"), 90 ],
                            [ new Date("2019-09-15"), 45 ]
                        ]
                    }
                }
            }
        },
        created(){
            //console.log(this.grafovi.prvi);
            this.axios
                .get(`/api/skladiste/statistika`)
                .then(response => {
                    this.grafovi.prvi.names = response.data.names;
                    for(var i = 0; i < response.data.names.length;i++){
                        this.grafovi.prvi.values.push([]);
                        for(var j = 0; j < response.data.values.length;j++){
                            if(response.data.values[j][response.data.names[i]] !== undefined)
                                this.grafovi.prvi.values[i].push(response.data.values[j][response.data.names[i]]);
                        }
                    }
                    console.log(this.grafovi.prvi);
                });
            this.axios
                .get(`/api/evidencija/statistika`)
                .then(response => {
                    console.log(response.data);
                    this.grafovi.drugi = response.data;
                });
        }
    }
</script>

<style scoped>

</style>