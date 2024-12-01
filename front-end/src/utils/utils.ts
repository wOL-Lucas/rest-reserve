import { Dialog, Loading, Notify, QSpinnerBall } from 'quasar'
import ConfirmPopUp from 'src/components/popup/ConfirmPopUp.vue'
import CopyPopUp from 'src/components/popup/CopyPopUp.vue'
import PopUp from 'src/components/popup/PopUp.vue'

class NotifyError {
	static success = (message: string): void => {
		Notify.create({
			message,
			color: 'positive',
			classes: 'text-h5'
		})
	}

	static error = (message: string): void => {
		Notify.create({
			message,
			color: 'negative',
			classes: 'text-h5'
		})
	}

	static warning = (message: string): void => {
		Notify.create({
			message,
			color: 'warning',
			classes: 'text-h5'
		})
	}

	static info = (message: string): void => {
		Notify.create({
			message,
			color: 'info',
			classes: 'text-h5'
		})
	}
}

class ShowLoading {
	static show = (message:string): void => {
		Loading.show({
			spinner: QSpinnerBall,
			spinnerColor: 'secondary',
			spinnerSize: 140,
			message,
			customClass: 'text-h5'
		})
	}

	static hide = (message?:string): void => {
		this.show(message || '')
		setTimeout(() => {
			Loading.hide()
		}, 1000)
	}
}

class ShowDialog {
	static show = (title:string, description:string, iconName = 'error'): void => {
		Dialog.create({
			component: PopUp,

			componentProps: {
				title,
				description,
				iconName
			}
		})
	}

	static showConfirm = (title: string, message: string, color?: string): Promise<boolean> => {
		return new Promise((resolve) => {
			Dialog.create({
				component: ConfirmPopUp,

				componentProps: {
					title,
					message,
					color
				}
			}).onOk(() => {
				resolve(true)
			}).onCancel(() => {
				resolve(false)
			})
		})
	}

	static showCopyToClipboard = (title:string, description:string, stringToCopy:string, redirectTo?:string): void => {
		Dialog.create({
			component: CopyPopUp,

			componentProps: {
				title,
				description,
				stringToCopy,
				redirectTo
			}
		})
	}
}

export { NotifyError, ShowLoading, ShowDialog }
