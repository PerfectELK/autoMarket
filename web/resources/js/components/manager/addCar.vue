<template>
    <div class="w-100 modal__body">
    <label for="type">Тип:</label>
    <select name="" id="type" class="form-control" v-model="currentType">
        <option v-for="t in type" v-bind:value="t.val">{{t.title}}</option>
    </select>

        <label for="title">Название:</label>
        <input id="title" type="text" class="form-control" v-model="name">

        <label for="price">Цена:</label>
        <input id="price" type="text" class="form-control" v-model="price">

        <label for="fuel">Топливо:</label>
        <input id="fuel" type="text" class="form-control" v-model="fuel">

        <label for="depOnChoose">{{ type[currentType].field }}</label>
        <input id="depOnChoose" type="text" class="form-control" v-model="depOnChoose">

        <label for="master">Хозяин:</label>
        <select name="" id="master" class="form-control" v-model="master">
            <option value="" v-for="master in masters" v-bind:value="master.id" >{{ master.id }}. {{master.name}} - {{master.phone}}</option>
        </select>

        <label for="picture">Картинка:</label>
        <input type="file" id="picture" class="form-control" v-on:input="inputPicture">

        <button v-on:click="addCar" class="btn btn-primary mt-3">Добавить авто</button>
    </div>
</template>

<script>
    const axios = require('axios');
    module.exports = {
            data(){
                return{
                    name:"",
                    price:"",
                    fuel:"",
                    depOnChoose:"",
                    master:"",
                    picture:"",
                    currentType:0,
                    type:[
                        {
                            title:"Легковая",
                            val:0,
                            field:"Количество мест"
                        },
                        {
                            title:"Грузовая",
                            val:1,
                            field:"Максимальная грузоподъемность"
                        }
                    ],
                    masters:[],
                }
            },
            methods:{
                inputPicture:function(event){
                    this.picture = event.target.files[0];
                },
                getMasters:function(){
                    let param = $.param({data:{c:'CarController',m:'getMasters'}});
                    axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}})
                        .then(response => {
                            this.masters = response.data;
                        });
                },
                addCar:function(){

                    if(this.name.trim() != "" &&
                        this.price.trim() != "" &&
                        this.fuel.trim() != "" &&
                        this.depOnChoose.trim() != "" &&
                        this.master != "" &&
                        this.price.trim() != "" &&
                        this.picture != void(0)
                    ){
                        let fd = new FormData;
                        let obj = {
                            name: this.name,
                            fuel: this.fuel,
                            type: this.type[this.currentType].val,
                            master:this.master,
                            price:this.price,
                            depOnChoose: this.depOnChoose,
                            c: 'CarController',
                            m: 'addCar',
                        };
                        fd.append('img',this.picture);
                        fd.append('formDataJson',JSON.stringify(obj));
                        axios.post('/api',fd, {headers: {
                            'Content-Type': 'multipart/form-data',
                        }}).then(response => {
                            if(response.data == 1){
                                this.name = "";
                                this.fuel = "";
                                this.price = "";
                                this.depOnChoose = "";
                                this.$emit('added');
                            }
                        });

                    }
                }
            },
        created(){
                this.getMasters();
        }
    }
</script>

<style>

</style>