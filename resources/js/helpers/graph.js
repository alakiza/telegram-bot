import { makeRequest } from './helper_base.js'

export function getGraph(params) {
    params.url = '/api/graph/get'
    params.method = 'get'
    makeRequest(params)
}