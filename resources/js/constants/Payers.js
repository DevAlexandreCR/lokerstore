export class Payers {
    static DOCUMENT_TYPE_CC = 'CC'
    static DOCUMENT_TYPE_AS = 'AS'
    static DOCUMENT_TYPE_CE = 'CE'
    static DOCUMENT_TYPE_PA = 'PA'
    static DOCUMENT_TYPE_RC = 'RC'
    static DOCUMENT_TYPE_TI = 'TI'

    static all = () => {
        return [
            this.DOCUMENT_TYPE_CC,
            this.DOCUMENT_TYPE_AS,
            this.DOCUMENT_TYPE_CE,
            this.DOCUMENT_TYPE_PA,
            this.DOCUMENT_TYPE_RC,
            this.DOCUMENT_TYPE_TI,
        ]
    }

}
