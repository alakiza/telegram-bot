import { makeRequest } from './helper_base.js'

export function getAvailableParameters(params) {
    params.url = '/api/probe/getparams'
    params.method = 'get'
    makeRequest(params)
}