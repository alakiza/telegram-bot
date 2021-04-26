import { makeRequest } from './helper_base.js'

export function getUsers(params) {
    params.url = '/api/user/get'
    params.method = 'get'
    makeRequest(params)
}

export function updateUser(params) {
    params.url = '/api/user/update'
    params.method = 'put'
    makeRequest(params)
}

export function deleteUser(params) {
    params.url = '/api/user/delete'
    params.method = 'post'
    makeRequest(params)
}
