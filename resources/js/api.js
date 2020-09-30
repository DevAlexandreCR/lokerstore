import Axios from "axios"

const url = `${process.env.MIX_APP_URL}/api/`

const getProducts = (query = null) => {
    console.log('get products...')
    return axios.get(`${url}products`, {
            params: query
        })
        .then(res => res.data)
}

const getCategories = () => {
    console.log('get categories...')
    return axios.get(`${url}categories`)
        .then(res => res.data)
}

const getColors = () => {
    console.log('get colors...')
    return axios.get(`${url}colors`)
    .then(res => res.data)
}

const getSizes = () => {
    console.log('get sizes...')
    return axios.get(`${url}type_sizes`)
    .then(res => res.data)
}

export default {
    getProducts,
    getCategories,
    getColors,
    getSizes
}
