import { makeRequest } from './helper_base.js'

export function getAvailableFields(params) {
    params.url = '/api/config/fields'
    params.method = 'get'
    makeRequest(params)
}

