import { makeRequest } from './helper_base.js'

export function getTargets(params) {
    params.url = '/api/target/get'
    params.method = 'get'
    makeRequest(params)
}

export function addTarget(params) {
    params.url = '/api/target/add'
    params.method = 'post'
    makeRequest(params)
}

export function deleteTarget(params) {
    params.url = '/api/target/delete'
    params.method = 'post'
    makeRequest(params)
}

export function updateTarget(params) {
    params.url = '/api/target/update'
    params.method = 'put'
    makeRequest(params)
}
