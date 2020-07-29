import Axios from "axios"

const url = `${process.env.MIX_APP_URL}/api/` 

const getProducts = () => {
   
    return axios.get(`${url}products`)
        .then(res => res.data)
}

const getCategories = () => {
   
    return axios.get(`${url}categories`)
        .then(res => res.data)
}

export default {
    getProducts,
    getCategories
}