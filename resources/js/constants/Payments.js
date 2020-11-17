export class Payments extends Array {
    static METHOD_CASH = 'cash'
    static METHOD_CARD = 'credit card'
    static METHOD_CREDIT = 'credit'

    static all = () => {
        return [
            this.METHOD_CASH,
            this.METHOD_CARD,
            this.METHOD_CREDIT
        ]
    }
}
