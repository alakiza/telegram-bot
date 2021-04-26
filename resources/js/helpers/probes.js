import { makeRequest } from './helper_base.js'

export function getBaseProbes(params) {
    params.url = '/api/probe/getbase'
    params.method = 'get'
    makeRequest(params)
}

export function getProbes(params) {
    params.url = '/api/probe/get'
    params.method = 'get'
    makeRequest(params)
}

export function addProbe(params) {
    params.url = '/api/probe/add'
    params.method = 'post'
    makeRequest(params)
}

export function deleteProbe(params) {
    params.url = '/api/probe/delete'
    params.method = 'post'
    makeRequest(params)
}

export function updateProbe(params) {
    params.url = '/api/probe/update'
    params.method = 'put'
    makeRequest(params)
}

export function getProbeAssignation(params) {
    params.url = '/api/probe/getassignation'
    params.method = 'get'
    makeRequest(params)
}
