const url = `${process.env.MIX_APP_URL}/api/` 

const getProducts = () => {
   
    return fetch(`${url}products`)
        .then(res => res.json())
        .then(res => res.data)
}

export default {
    getProducts
}