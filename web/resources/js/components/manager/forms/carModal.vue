<template>
    <div class="modal fade" id="carModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content w-100">
                <div class="modal-header w-100">
                    <h5 class="modal-title" id="exampleModalLabel">Авто</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body w-100 modal__body">
                    <p class="alert alert-danger display-none-car  display-none w-100 mt-2">{{ alert.car }}</p>
                    <div class="img__container" v-if="description">
                        <img v-bind:src="description.img" alt="">
                    </div>
                    <div v-if="description" class="w-100 modal__body">
                    <p class="card-text w-100">Активно:
                        <select name=""  class="form-control" v-model="active">
                            <option  v-for="a in actives" v-bind:value="a.val" v-bind:selected="active == a.val">{{ a.title }}</option>
                        </select>
                    </p>

                    <p class="card-text w-100">Модель:
                        <input type="text" class="form-control" v-model="model">
                    </p>

                    <p class="card-text w-100">Тип :
                        <select name=""  class="form-control" v-on:change="this.typeChange" v-model="type">
                            <option v-for="typ in types"  v-bind:value="typ.val" v-bind:selected="type == typ.val ">{{ typ.title }}</option>
                        </select>
                    </p>

                    <p class="card-text w-100" v-if="description">Топливо :
                        <input type="text" class="form-control" v-model="fuel">
                    </p>

                    <p class="card-text w-100" v-if="description">{{load[0]}}
                        <input type="text" class="form-control" v-model="depOnChoose">
                    </p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button class="btn btn-primary mt-3" v-on:click="reSaveCar">Изменить данные</button>
                        </div>
                    </div>

                    <div class="w-100 modal__body mt-5">
                        <h5 class="modal-title">Хозяин</h5>
                        <p class="alert alert-danger display-none-master  display-none w-100 mt-2">{{ alert.master }}</p>
                        <p class="card-text w-100">Имя:
                            <input type="text" class="form-control" v-model="master.name">
                        </p>
                        <p class="card-text w-100">Телефон:
                            <input type="text" class="form-control" v-model="master.phone">
                        </p>
                        <p class="card-text w-100">Паспорт:
                            <input type="text" class="form-control" v-model="master.passport">
                        </p>
                        <p class="card-text w-100">Номер водительского удостоверения:
                            <input type="text" class="form-control" v-model="master.driverNum">
                        </p>
                        <button class="btn btn-primary" v-on:click="reSaveMaster">Изменить данные владельца</button>
                    </div>
                </div>
                <div class="modal-footer w-100">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const axios = require('axios');
    module.exports = {
        props:['description'],
        data:function(){
            return{
                alert:{
                  master:'',
                  car:''
                },
                master:{
                  id:'',
                  name:'',
                  phone:'',
                  passport:'',
                  driverNum:''
                },
                type:'',
                active:'',
                model:'' ,
                fuel:'',
                depOnChoose:'',
                loadCapOrNum:[],
                typeArr:['Легковой','Грузовой'],
                actives:[
                    {
                        title:"Активно",
                        val:true,
                    },
                    {
                        title:"Не активно",
                        val:false,
                    }
                ],
                types: [
                    {
                        title: "Легковой",
                        val: 0,
                        field: "Количество мест"
                    },
                    {
                        title: "Грузовой",
                        val: 1,
                        field: "Максимальная грузоподъемность"
                    }
                ],
                a:true,
            }
        },
        methods:{
            typeChange:function(){
                if(this.type){
                    this.load[0] = this.types[1].field;
                }else{
                    this.load[0] = this.types[0].field;
                }
            },
            getMaster:function(){

                let param = $.param({data:{c:'CarController',m:'getMaster',id:this.description.master}});
                axios.post('/api', param, { headers: {'Content-type': 'application/x-www-form-urlencoded',}})
                    .then(response => {
                        let m = response.data[0];
                        this.master.id = m.id;
                        this.master.name = m.name;
                        this.master.driverNum = m.driverNum;
                        this.master.passport = m.passport;
                        this.master.phone = m.phone;

                    });
            },
            reSaveMaster:function(){
                let obj = {
                    id:this.master.id,
                    name:this.master.name,
                    phone:this.master.phone,
                    passport:this.master.passport,
                    driverNum:this.master.driverNum
                };
                let param = $.param({data:{c:'CarController',m:'updateCustomer',params:obj}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                    then(response => {
                    if(response.data == 1){
                        this.getMessage('master',"Клиент изменен",'.display-none-master');
                        this.$emit('pelkchange');
                    }
                })
            },
            reSaveCar:function(){
              let obj = {
                  id:this.description.id,
                  type:this.type,
                  model:this.model,
                  active:this.active,
                  fuel:this.fuel,
                  depOnChoose: this.depOnChoose
              };
                let param = $.param({data:{c:'CarController',m:'updateCar',params:obj}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                then(response => {
                    if(response.data == 1){
                        this.getMessage('car',"Автомобиль изменен",'.display-none-car');
                        this.$emit('pelkchange');
                    }
                })
            },
            getMessage:function(alert,msg,selector){
                this.alert[alert] = msg;
                $(selector).fadeIn(1000);
                $(selector).fadeOut(1000);
            },
        },
        computed:{
            load:function(){
                let arr = [];
                if(this.description.loadCapacity != null && this.description.loadCapacity != 0){
                    arr.push('Грузоподъемность');
                    arr.push(this.description.loadCapacity);
                }else{
                    arr.push('Количество мест');
                    arr.push(this.description.numberOfSeats);
                }
                return arr;
            },
            getDescr:function(){
                if(this.a && this.description != void(0)){
                    this.active = this.description.active;
                    this.type = this.description.type;
                    this.model = this.description.title;
                    this.fuel = this.description.fuel;
                    this.depOnChoose = this.load[1];
                    this.getMaster();
                }
            }
        },
        created(){
        },
        updated(){
            this.getDescr;
        }
    }
</script>

<style>
    .modal__body{
        flex-direction: column;
        position: relative;
    }
    .img__container{
        max-width: 100%;

    }
    .img__container > img{
        max-width: 100%;
        max-height: 200px;
    }
    .display-none{
        display: none;
    }
</style>