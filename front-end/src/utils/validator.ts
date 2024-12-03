import { cnpj, cpf } from 'cpf-cnpj-validator'
import { Formatter } from './formatter'

export class Validator {
	static hasMultipleWords = (value: string): boolean => {
		value = Formatter.clearNumbers(value)
		return value.split(' ').length > 1
	}

	static isValidCPF = (value: string): boolean => {
		return cpf.isValid(value)
	}

	static isValidPhoneNumber = (value: string): boolean => {
		const formattedValue = Formatter.clearSymbolsAndLetters(value)
		return /^([14689][0-9]|2[12478]|3([1-5]|[7-8])|5([13-5])|7[193-7])9[0-9]{8}$/.test(formattedValue)
	}

	static isValidEmail = (value: string): boolean => {
		return /^[\w.-]+(\+[\w.-]+)?@([\w-]+\.)+[\w-]{2,4}$/.test(value)
	}

	static isValidPassword = (value: string): boolean => {
		return /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+}{":;'?/>.<,])(?=.*[a-zA-Z]).{8,}$/.test(value)
	}

	static isValidCNPJ = (value: string): boolean => {
		return cnpj.isValid(value)
	}

	static isValidName = (name: string): boolean => {
		return /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/.test(name)
	}

	static isValidNumber = (value: string): boolean => {
		return /^[0-9]+$/.test(value)
	}

	static isValidDate (dateString: string): boolean {
		// Regular expression to match the dd/mm/yyyy format
		const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/

		// Validate format
		const match = dateString.match(dateRegex)
		if (!match) {
			return false
		}

		const [, day, month, year] = match.map(Number)

		// Validate ranges
		if (month < 1 || month > 12) {
			return false
		}

		if (day < 1 || day > 31) {
			return false
		}

		// Check for months with fewer than 31 days
		const monthsWith30Days = [4, 6, 9, 11]
		if (monthsWith30Days.includes(month) && day > 30) {
			return false
		}

		// Check for February and leap year rules
		if (month === 2) {
			const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0
			if (isLeapYear && day > 29) {
				return false
			}
			if (!isLeapYear && day > 28) {
				return false
			}
		}

		return true
	}

	static isOlderThan18 = (dateString: string): boolean => {
		// get the date of birth by brazilian format
		const formattedDate = Formatter.brazilianDateToDate(dateString)

		// get date
		const date = new Date(formattedDate)

		// get the current dat
		const now = new Date()

		const diff = now.getTime() - date.getTime()
		const age = diff / (1000 * 60 * 60 * 24 * 365.25)

		return age >= 18
	}
}
