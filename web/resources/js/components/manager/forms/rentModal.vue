<template>
    <div class="modal fade" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content w-100">
                <div class="modal-header w-100">
                    <h5 class="modal-title" id="exampleModalLabel">Список аренд</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body w-100 modal__body">
                    <div class="table-responsive table">
                        <p class="alert alert-danger display-none-rent  display-none w-100 mt-2">{{ alert.rent }}</p>
                        <h4 class="w-100 text-center">{{ description.title }}</h4>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Начало</th>
                                    <th>Конец</th>
                                    <th>Стоимость</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="rent in rents">
                                <td>
                                    {{rent.beginFormat}}
                                </td>
                                <td>{{ rent.endFormat }}</td>
                                <td>{{ rent.price }}</td>
                                <td>
                                    <button class="btn btn-danger" v-bind:disabled="!rent.mayDelete" v-on:click="deleteRent(rent.id)">
                                        Удалить
                                    </button>
                                </td>
                                <td>
                                    <button  class="btn btn-primary" v-bind:disabled="!rent.mayDelete" v-on:click="changeRent(rent.id)">
                                        Редактировать
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p>Дата начала:</p>
                        <date-picker v-model="date.begin" style="width:100%;"></date-picker>
                        <p>Время начала:</p>
                        <input type="time" v-model="time.begin" class="form-control">
                    </div>
                    <hr>
                    <div>
                        <p>Дата окончания:</p>
                        <date-picker v-model="date.end" style="width:100%;"></date-picker>
                        <p>Время окончания:</p>
                        <input type="time" v-model="time.end" class="form-control">
                    </div>
                    <div>
                        <p>Цена:</p>
                        <input type="text" v-model="car.price" class="form-control">
                    </div>
                    <button v-bind:disabled="timeIsFree" class="btn btn-primary mt-3"
                    v-on:click="addCarRent">Добавить арнеду</button>
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
    const datePicker = require('vue!./../../vendor/date.vue');
    module.exports = {
        props:['description'],
        data(){
            return{
                alert:{
                  rent:''
                },
                car:{
                    id:'',
                    title:'',
                    master:'',
                    price:'',
                },
                rents:[],
                date:{
                    begin:'',
                    end:''
                },
                time:{
                    begin:'',
                    end:'',
                },
                timeIsFree:true,
            }
        },
        components:{
          datePicker: datePicker
        },
        methods:{
            changeRent:function(id){
                if(!this.validateInput()){return false;}

                let arrBeginDates = this.date.begin.split('.').reverse();
                let arrBeginTimes = this.time.begin.split(':');
                let beginUnix = new Date(arrBeginDates[0],parseInt(arrBeginDates[1] - 1),arrBeginDates[2],arrBeginTimes[0],arrBeginTimes[1]).getTime()/1000;

                let arrEndDates = this.date.end.split('.').reverse();
                let arrEndTimes = this.time.end.split(':');
                let endUnix = new Date(arrEndDates[0],parseInt(arrEndDates[1] - 1),arrEndDates[2],arrEndTimes[0],arrEndTimes[1]).getTime()/1000;
                let obj = {
                    id:id,
                    beginTime:beginUnix,
                    endTime:endUnix,
                    carId:this.description.id,
                    price:this.car.price,
                };
                let param = $.param({data:{c:'RentController',m:'ChangeCarRent',params:obj}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                then(response => {
                    if(response.data){
                        console.log(response.data);
                        this.getMessage('rent',"Аренда изменена",'.display-none-rent');
                        this.getCarRents();
                    }
                });
            },
            deleteRent:function(id){
                let obj = {
                    id: id
                };
                let param = $.param({data: {c: 'RentController', m: 'deleteRent', params: obj}});
                axios.post('/api', param, {headers: {'Content-type': 'application/x-www-form-urlencoded',}}).then(response => {
                    this.getMessage('rent',"Аренда удалена",'.display-none-rent');
                    this.getCarRents();
                });
            },
            getCarRents:function(){
                let obj = {
                    id:this.car.id
                };
                let param = $.param({data:{c:'RentController',m:'getCarRents',params:obj}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                    then(response => {
                    this.rents = this.formatTime(response);
                });
            },
            addCarRent:function(){
                let arrBeginDates = this.date.begin.split('.').reverse();
                let arrBeginTimes = this.time.begin.split(':');
                let beginUnix = new Date(arrBeginDates[0],parseInt(arrBeginDates[1] - 1),arrBeginDates[2],arrBeginTimes[0],arrBeginTimes[1]).getTime()/1000;

                let arrEndDates = this.date.end.split('.').reverse();
                let arrEndTimes = this.time.end.split(':');
                let endUnix = new Date(arrEndDates[0],parseInt(arrEndDates[1] - 1),arrEndDates[2],arrEndTimes[0],arrEndTimes[1]).getTime()/1000;
                let obj = {
                    beginTime:beginUnix,
                    endTime:endUnix,
                    id:this.description.id,
                    price:this.car.price,
                };
                let param = $.param({data:{c:'RentController',m:'addCarRent',params:obj}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                then(response => {
                    if(response.data){
                        this.getMessage('rent',"Аренда добавлена",'.display-none-rent');
                        this.getCarRents();
                    }
                });
            },
            formatTime:function(arr){
                if(arr.data != void(0)){
                    let formatedArr = [];
                    arr.data.forEach((item,index,arr) => {

                        var date = new Date(item.beginTime * 1000);
                        var year = date.getFullYear();
                        var month = "0" + (date.getMonth() + 1) ;
                        var day = "0" + date.getDate();
                        var hours = date.getHours();
                        var minutes = "0" + date.getMinutes();
                        var formattedBeginTime = day.substr(-2) + "." + month.substr(-2) + "." + year  + "-" + hours +":"+ minutes.substr(-2);
                        let curent = new Date().getTime();
                        let mayDelete = false;
                        if(date.getTime() - curent >= ((60*30)*1000)){
                            mayDelete = true;
                        }

                        var date = new Date(item.endTime * 1000);
                        var year = date.getFullYear();
                        var month = "0" + (date.getMonth() + 1) ;
                        var day = "0" + date.getDate();
                        var hours = date.getHours();
                        var minutes = "0" + date.getMinutes();
                        var formattedEndTime = day.substr(-2) + "." + month.substr(-2) + "." + year + "-" + hours +":"+ minutes.substr(-2);
                        formatedArr.push({
                            id:item.id,
                            beginUnix: item.beginTime,
                            beginFormat: formattedBeginTime,
                            endUnix: item.endTime,
                            endFormat: formattedEndTime,
                            price: item.price,
                            mayDelete: mayDelete
                        });
                    });
                    return formatedArr;
                }
            },
            validateInput:function(){
                if(this.date.begin == "" || this.date.end == ""){return false;}
                if(this.time.begin == "" || this.time.end == ""){return false;}
                if(this.car.price == ""){return false;}

                let arrBeginDates = this.date.begin.split('.').reverse();
                let arrBeginTimes = this.time.begin.split(':');
                let beginUnix = new Date(arrBeginDates[0],parseInt(arrBeginDates[1] - 1),arrBeginDates[2],arrBeginTimes[0],arrBeginTimes[1]).getTime();

                let arrEndDates = this.date.end.split('.').reverse();
                let arrEndTimes = this.time.end.split(':');
                let endUnix = new Date(arrEndDates[0],parseInt(arrEndDates[1] - 1),arrEndDates[2],arrEndTimes[0],arrEndTimes[1]).getTime();
                if(!this.checkRents(beginUnix / 1000 ,endUnix / 1000)){return false;}
                console.log(1);
                if(endUnix <= beginUnix){return false;}
                if(endUnix > beginUnix){return true;}

            },
            checkRents:function(beginUnix,endUnix){
                console.log(beginUnix);
                console.log(this.rents[0].beginUnix);
                if(this.rents.length < 1){return true;}
                for(let i = 0; i < this.rents.length; i++){
                    if((Math.min(beginUnix, endUnix) < Math.max(this.rents[i].beginUnix, this.rents[i].endUnix))
                        && ((Math.min(this.rents[i].beginUnix, this.rents[i].endUnix) < Math.max(beginUnix, endUnix)))){
                        return false;
                        }
                }
                return true;
            },
            checkTime:function(){
                if(this.validateInput()){
                    this.timeIsFree = false;
                }else{
                    this.timeIsFree = true;
                }
            },
            getMessage:function(alert,msg,selector){
                this.alert[alert] = msg;
                $(selector).fadeIn(1000);
                $(selector).fadeOut(1000);
            },

        },
        computed:{
            getDescr:function(){
                if(this.description != void(0)){
                    this.car.id = this.description.id;
                    this.car.title = this.description.title;
                    this.car.master = this.description.master;
                    this.car.price = this.description.price;
                    this.getCarRents();
                }
            },
        },
        updated(){
            this.getDescr;
            this.checkTime();
        },
        created(){
            this.getDescr;
        }
    }
</script>

<style>
</style>