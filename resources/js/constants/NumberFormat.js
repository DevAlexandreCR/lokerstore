export default class Format {
  static format (number) {
    const val = new Intl.NumberFormat().format(Math.round(number))
    return `$ ${val}`
  }
}
