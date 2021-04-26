import { makeRequest } from './helper_base.js'

export function getDevices(params) {
    params.url = '/api/device/get'
    params.method = 'get'
    makeRequest(params)
}

export function addDevice(params)
{
    params.url = '/api/device/add'
    params.method = 'post'
    makeRequest(params)
}

export function deleteDevice(params) {
    params.url = '/api/device/delete'
    params.method = 'post'
    makeRequest(params)
}

export function updateDevice(params) {
    params.url = '/api/device/update'
    params.method = 'put'
    makeRequest(params)
}
