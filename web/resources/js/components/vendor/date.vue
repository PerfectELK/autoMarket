<template>
    <div class="datePicker__container">
        <input class="input__date" type="text"  @click="showTimeWindow()" v-model="inputValue
" readonly >
        <div class="time-window" v-if="modalOpen">
            <div class="control__panel">
                <button class="control__panel-left" @click="minusMonth()"></button>
                <span class="control__panel-select_date">
                {{ inputValue }}
                </span>
                <button class="control__panel-right" @click="plusMonth()"></button>
            </div>
            <div class="day__table">
                <button class="day__table-item" v-for="week in DayOfWeek">{{week}}</button>
                <button class="day__table-item" v-for="day in DayArray" v-bind:class="{isDayActive:day.current}" @click="setDay(day.day)">{{ day.day }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                currentMonth:new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                currentDay: new Date().getDate(),
                currentMonthIndex: new Date().getMonth(),
                currentYearIndex: new Date().getFullYear(),
                inputValue:"",
                DayArray:[],
                modalOpen:false,
                DayOfWeek:['пн','вт','ср',"чт","пт","сб","вс"],
            }
        },
        props:['value'],
        methods:{
            updateValue:function(value){
                this.$emit('input',value);
            },
            MarginForDayOfWeek:function(){
                let date = new Date(this.currentYear,this.currentMonth,1).getDay();
                let a = [];
                for(let j = 1; j <  date; j++) {a.push({day:'\u00A0',current:false});}
                this.DayArray = a.concat(this.DayArray);
            },
            minusMonth:function(){
                this.currentDay = 1;
                if(this.currentMonth != 0){
                    this.currentMonth--;
                }else{
                    this.currentYear--;
                    this.currentMonth = 11;
                }
                this.dayInMonth();
                this.setValueOnInput();
                this.createDayArray();
                this.MarginForDayOfWeek();
            },
            plusMonth:function(){
                this.currentDay = 1;
                if(this.currentMonth != 11){
                    this.currentMonth++;
                }else{
                    this.currentYear++;
                    this.currentMonth = 0;
                }
                this.dayInMonth();
                this.setValueOnInput();
                this.createDayArray();
                this.MarginForDayOfWeek();
            },
            setDay:function(day){
                this.currentDay = day;
                this.setValueOnInput();
                this.createDayArray();
                this.MarginForDayOfWeek();
                this.showTimeWindow();
            },
            dayInMonth:function(){
                return 33 - new Date(this.currentYear, this.currentMonth, 33).getDate()
            },
            setValueOnInput:function(){
                this.inputValue = this.getCurrentDay() + "." + this.getCurrentMonth() + "." + this.currentYear;
                this.updateValue(this.inputValue);
            },
            getCurrentMonth:function(){
                if((this.currentMonth + 1) <= 9){
                    let cm = this.currentMonth + 1;
                    return "0" + cm
                }else{
                    return this.currentMonth + 1;
                }
            },
            getCurrentDay:function(){
                if((this.currentDay) <= 9){
                    let cm = this.currentDay;
                    return "0" + cm
                }else{
                    return this.currentDay;
                }
            },
            showTimeWindow:function(){
                this.modalOpen = !this.modalOpen;
            },
            createDayArray:function(){
                let j = [];
                for(let i = 1; i <= this.dayInMonth();i++){
                    if(this.currentDay == i){
                        j.push({day:i,current:true});
                    }else{
                        j.push({day:i,current:false});
                    }
                }
                this.DayArray = j;
            },
            closeTimeWindow:function(e){

                for(let i = 0; i < e.path.length; i++)
                    if (e.path[i].className == 'datePicker__container') return;

                this.modalOpen = false;
            }
        },
        created(){
            this.setValueOnInput();
            this.createDayArray();
            this.MarginForDayOfWeek();
            let ctx = this;
            document.addEventListener('click', function(e) {ctx.closeTimeWindow(e)});
        }
    }
</script>

<style>
    .time-window{
        margin: 0 auto;
        position: absolute;
        width:100%;
        top:0;
        left:0;
        z-index: 1000;
        background-color:#dddddd ;
    }
    .datePicker__container{
        max-width: 100%;
        text-align: center;
        position: relative;
        display: inline-block;
    }
    .day__table{
        width: 100%;
        text-align: left;
    }
    .control__panel > button{
        width:30px;
        height: 30px;
        border: none;
        padding: 0;
        outline: none;
        position: relative;

    }
    .isDayActive{
        background-color: #adcbfb;
    }
    .control__panel{
        max-width: 180px;
        text-align: center;
        margin: 0 auto;
    }
    .day__table-item{
        width:14%;
        height: 40px;
        border: none;
        padding: 0;
        outline: none;
    }
    .day__table-item:active{
        background-color: #adcbfb;
    }
    .day__table-item:focus{
        background-color: #adcbfb;
    }
    .control__panel-left::before{
        content: "";
        width: 50%;
        height: 1px;
        border-radius: 20px;
        background-color: #000;
        position: absolute;
        top:35%;
        left:50%;
        transform: translate(-50%,-50%) rotate(-45deg);
    }
    .control__panel-left::after{
        content: "";
        width: 50%;
        height: 1px;
        border-radius: 20px;
        background-color: #000;
        position: absolute;
        top:69%;
        left:50%;
        transform: translate(-50%,-50%) rotate(45deg);
    }
    .control__panel-right::before{
        content: "";
        width: 50%;
        height: 1px;
        border-radius: 20px;
        background-color: #000;
        position: absolute;
        top:35%;
        left:50%;
        transform: translate(-50%,-50%) rotate(45deg);
    }
    .control__panel-right::after{
        content: "";
        width: 50%;
        height: 1px;
        border-radius: 20px;
        background-color: #000;
        position: absolute;
        top:69%;
        left:50%;
        transform: translate(-50%,-50%) rotate(-45deg);
    }
    .control__panel-select_date{
        height: auto;
        width: 100px;
        display: inline-block;
        font-size: 19px;
        vertical-align: top;
        margin-top: 4px;
    }
    .input__date{
        width:100%;
        outline: none;
        height: 25px;
        font-size: 23px;
        border: 0.5px solid #d7d2fb;
        text-align: center;
    }
</style>