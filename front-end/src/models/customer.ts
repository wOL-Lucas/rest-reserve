import { Formatter } from 'src/utils/formatter'

export class Customer {
	constructor (
		public firstName = '',
    public lastName = '',
		public email = '',
    public password = '',
		public document = '',
		public role = '',
	) {}

	static fromJson (json: any): Customer {
		return new Customer(
			json.firstName || '',
      json.lastName || '',
			json.email || '',
      json.password || '',
			json.document || '',
      json.role || '',
		)
	}

	public toJson (): any {
		return {
			first_name: this.firstName,
      last_name: this.lastName,
			document: Formatter.clearSymbolsAndLetters(this.document),
			email: this.email,
      password: this.password,
      role: this.role,
		}
	}
}
