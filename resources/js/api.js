import axios from 'axios'

const url = `${process.env.MIX_APP_URL}/api/`

const getProducts = (query = null) => {
  return axios.get(`${url}products`, {
    params: query
  })
    .then(res => res.data)
}

const getCategories = () => {
  return axios.get(`${url}categories`)
    .then(res => res.data)
}

const getColors = () => {
  return axios.get(`${url}colors`)
    .then(res => res.data)
}

const getSizes = () => {
  return axios.get(`${url}type_sizes`)
    .then(res => res.data)
}

export default {
  getProducts,
  getCategories,
  getColors,
  getSizes
}
