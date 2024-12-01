import axios from 'axios'
import HttpRequest from './httpRequest'
import Http from './http'

const BASE_URL = process.env.BASE_URL
const MAX_RETRIES = 3


export interface PaginatedResponse {
	data: any[]
	totalItems: number
}

export class AxiosHttp implements Http {
	private static instance: AxiosHttp | null = null

	static getInstance(): AxiosHttp {
		if (!AxiosHttp.instance) {
			AxiosHttp.instance = new AxiosHttp()
		}
		return AxiosHttp.instance
	}

	static isLoggedIn = () => {
		return !!localStorage.getItem('accessToken')
	}

	async refreshToken(): Promise<boolean> {
		for (let i = 0; i < 3; i++) {
			try {
				const refreshToken = localStorage.getItem('refreshToken')
				const response = await axios.post(`${BASE_URL}/refresh-token`, null, {
					headers: {
						Authorization: `Bearer ${refreshToken}`
					}
				})
	
				localStorage.setItem('accessToken', response.data.accessToken)
				localStorage.setItem('refreshToken', response.data.refreshToken)
				return true
			} catch (error) {
			}
		}
		return false
	}

	async post<T> (httpRequest: HttpRequest): Promise<T> {
		const token = localStorage.getItem('accessToken')
		httpRequest.headers = {
			...httpRequest.headers,
			'Authorization': httpRequest.basicAuth ? `Basic ${btoa(`${httpRequest.basicAuth.username}:${httpRequest.basicAuth.password}`)}` : `Bearer ${token}`,
		}

		try {
			const response = await axios.post(
				`${BASE_URL}${httpRequest.path}`,
				httpRequest.body,
				{
					headers: httpRequest.headers
				}
		)
			return response.data
		} catch (error: any) {
			return this.handleError(error, 'post', httpRequest)
		}
	}
	
	async get<T> (httpRequest: HttpRequest): Promise<T> {
		const token = localStorage.getItem('accessToken')
		httpRequest.headers = {
			...httpRequest.headers,
			Authorization: `Bearer ${token}`,
		}
		httpRequest.params = new URLSearchParams(httpRequest.params)
		try {
			const response = await axios.get(
				`${BASE_URL + httpRequest.path}?${httpRequest.params.toString()}`,
				{
					headers: httpRequest.headers
				}
			)
			return response.data
		} catch (error: any) {
			return this.handleError(error, 'get', httpRequest)
		}
	}
	
	async delete (httpRequest: HttpRequest): Promise<void> {
		const token = localStorage.getItem('accessToken')
		httpRequest.params = new URLSearchParams(httpRequest.params)
		httpRequest.headers = {
			...httpRequest.headers,
			Authorization: `Bearer ${token}`,
		}
		try {
			await axios.delete(
				`${BASE_URL + httpRequest.path}${httpRequest.params.toString()}`,
				{
					headers: httpRequest.headers
				}
			)
		} catch (error: any) {
			this.handleError(error, 'delete', httpRequest)
		}
	}
	
	async put<T> (httpRequest: HttpRequest): Promise<T> {
		const token = localStorage.getItem('accessToken')
		httpRequest.headers = {
			...httpRequest.headers,
			Authorization: `Bearer ${token}`,
		}
	
		try {
			const response = await axios.put(
				`${BASE_URL + httpRequest.path}`, httpRequest.body,
				{
					headers: httpRequest.headers
				}
			)
			return response.data
		} catch (error: any) {
			return this.handleError(error, 'put', httpRequest)
		}
	}
	
	static logout = () => {
		localStorage.clear()
		window.location.href = '/'
	}

	async handleError(error: any, method: 'get' | 'post' | 'put' | 'delete', httpRequest: HttpRequest): Promise<any> {
		if (error.response && error.response.status === 401) {
			if (!httpRequest.retries) httpRequest.retries = 0
			const result = await this.refreshToken()
			if (httpRequest.retries < MAX_RETRIES && result) {
				httpRequest.retries++
				return this[method](httpRequest)
			}
		}

		throw error
	}
}


