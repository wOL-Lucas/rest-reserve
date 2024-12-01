export class NotAcceptableError extends Error {
	constructor (message = 'Não aceitável') {
		super(message)
		this.name = 'NotAcceptableError'

		Object.setPrototypeOf(this, NotAcceptableError.prototype)
	}
}
