export const METHOD_CASH = 'cash'
export const METHOD_CARD = 'credit card'
export const METHOD_CREDIT = 'credit'

export function all () {
  return [
    this.METHOD_CASH,
    this.METHOD_CARD,
    this.METHOD_CREDIT
  ]
}
