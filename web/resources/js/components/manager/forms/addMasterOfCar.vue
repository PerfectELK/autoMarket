<template>
    <div class="w-100 modal__body">
        <p class="alert alert-danger display-none w-100 mt-2">{{ alert }}</p>

        <label for="FIO">ФИО</label>
        <input type="text" id="FIO" class="form-control" v-model="fio">

        <label for="Passport">Паспорт</label>
        <input type="text" id="Passport" class="form-control" v-model="passport">

        <label for="DPnum">Номер ВУ</label>
        <input type="text" id="DPnum" class="form-control" v-model="driverNum">

        <label for="phone">Телефон</label>
        <input type="tel" class="form-control" id="phone" v-model="phone">

        <button class="btn btn-primary mt-5" v-on:click="this.add">Добавить владельца</button>
    </div>
</template>

<script>

    const axios = require('axios');

        module.exports = {
            data:function(){
                return{
                    fio:"",
                    passport:"",
                    driverNum:"",
                    phone:"",
                    alert:""
                }
            },
            methods:{
                add:function(){
                    if(this.fio.trim() != "" && this.passport.trim() != "" && this.driverNum.trim() && this.phone.trim() != ""){
                        let data = {
                            fio:this.fio,
                            passport:this.passport,
                            driverNum:this.driverNum,
                            phone:this.phone,
                        };
                        let param = $.param({data:{c:'CarController',m:'addMaster',params:data}});
                        axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}})
                            .then(response => {
                                if(response.data){
                                    this.getMessage("Клиент успешно добавлен");
                                    this.clearFields();
                                }else{
                                    this.getMessage("Произошла ошибка, избейте разработчика");
                                }

                            }).catch(e => {

                        });
                    }else{
                        this.getMessage("Заполните все поля")
                    }
                },
                getMessage:function(msg){
                    this.alert = msg;
                    $('.display-none').fadeIn(1000);
                    $('.display-none').fadeOut(1000);
                },
                clearFields:function(){
                    this.fio = "";
                    this.passport = "";
                    this.driverNum = "";
                    this.phone = "";
                }
            }
        }
</script>

<style>
    .modal__body{
        flex-direction: column;
        align-items: baseline;
    }
    .display-none{
        display: none;
    }
</style>