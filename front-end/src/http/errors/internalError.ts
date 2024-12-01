export class InternalError extends Error {
	constructor (message = 'Ocorreu um erro inesperado. Tente novamente mais tarde.') {
		super(message)
		this.name = 'InternalError'

		Object.setPrototypeOf(this, InternalError.prototype)
	}
}
