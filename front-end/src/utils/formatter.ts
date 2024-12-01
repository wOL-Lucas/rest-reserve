import { cnpj, cpf } from 'cpf-cnpj-validator'

export class Formatter {
	static clearSymbols = (value: string): string => {
		return value.replace(/[^0-9a-zA-Z]/g, '')
	}

	static clearString = (value: string): string => {
		return value.replace(/\D/g, '')
	}

	static clearNumbers = (value: string): string => {
		return value.replace(/[0-9]/g, '')
	}

	static clearSymbolsAndLetters = (value: string): string => {
		return value.replace(/[^0-9]/g, '')
	}

	static clearSpacesAndSymbols = (value: string): string => {
		return value.replace(/[^0-9a-zA-Z]/g, '')
	}

	static formatNumberToBRCurrency = (value: number): string => {
		return Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value / 100)
	}

	static timestampToDateBR = (timestamp: number): string => {
		const date = new Date(timestamp * 1000)

		if (date.getUTCHours() === 0) {
			date.setUTCHours(3)
		}

		return date.toLocaleString('pt-BR')
	}

	static dateToTimestamp = (dateString:any): number => {
		const parts = dateString.split('/')
		const day = parseInt(parts[0], 10)
		const month = parseInt(parts[1], 10) - 1
		const year = parseInt(parts[2], 10)
		return new Date(year, month, day).getTime() / 1000
	}

	static phoneToBR = (value: string): string => {
		Formatter.clearSymbols(value)
		if (value.length === 13) {
			value = value.slice(0, 12)
		}
		return value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
	}

	static strToCpf = (string: string): string => {
		return cpf.format(string)
	}

	static strToCnpj = (string: string): string => {
		return cnpj.format(string)
	}

	static strToCep = (string: string): string => {
		return string.replace(/(\d{5})(\d{3})/, '$1-$2')
	}

	static intToCurrencyK = (value: number): string => {
		value = value / 100
		let formattedValue = ''
		if (value >= 1000) {
			formattedValue = (value / 1000).toFixed(0) + 'k'
		} else {
			formattedValue = value.toFixed(0)
		}
		return formattedValue
	}

	static brlToCents = (value:string): number => {
		value = value.replace(/\D/g, '')
		return parseInt(value) * 100
	}

	static intToMonth = (value: number): string => {
		const months = [
			'Janeiro',
			'Fevereiro',
			'Março',
			'Abril',
			'Maio',
			'Junho',
			'Julho',
			'Agosto',
			'Setembro',
			'Outubro',
			'Novembro',
			'Dezembro'
		]
		return months[value - 1]
	}

	static capitalize = (value: string): string => {
		return value.charAt(0).toUpperCase() + value.slice(1)
	}

	static brazilianDateToDate = (date: string): string => {
		const parts = date.split('/')
		return `${parts[2]}-${parts[1]}-${parts[0]}`
	}

	static dateToBrazilianDate = (date: string): string => {
		const parts = date.split('-')
		return `${parts[2]}/${parts[1]}/${parts[0]}`
	}
}
