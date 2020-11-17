export default class  Format {
    static format(number){
        let val = new Intl.NumberFormat().format(Math.round(number))
        return `$ ${val}`
    }
}
