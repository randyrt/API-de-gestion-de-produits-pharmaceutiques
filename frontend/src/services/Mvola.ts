import axios from 'axios'

const api = axios.create({
  baseURL: 'https://pre-api.mvola.mg/mvola/mm',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': `BeyJ4NXQiOiJaREUzWW1RNFkyRmtZekprTmpNMk5EVmtZVE5oTkRSak16azFObVEyWXprelkyUTFaVFZqWVEiLCJraWQiOiJNVGRsTXpneFpqZGtNakk0WmpKbVlUZ3dNRFJpWWpNMU1tUmhOamxoTUdNME1XTmtPV05tT1RobU16VXlNMlUxTkRZNE5UWXhOMk01TW1SbU5XUTRPQV9SUzI1NiIsInR5cCI6ImF0K2p3dCIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiJyYW5keXRzaW9yeUBnbWFpbC5jb20iLCJhdXQiOiJBUFBMSUNBVElPTiIsImF1ZCI6InFMZDVqeU1qYzRjZHM5WUJmaW8wcHBlQXN6UWEiLCJuYmYiOjE3NjE1MDMzNzAsImF6cCI6InFMZDVqeU1qYzRjZHM5WUJmaW8wcHBlQXN6UWEiLCJzY29wZSI6IkVYVF9JTlRfTVZPTEFfU0NPUEUiLCJpc3MiOiJodHRwczpcL1wvZGV2ZWxvcGVyLm12b2xhLm1nXC9vYXV0aDJcL3Rva2VuIiwicmVhbG0iOnsic2lnbmluZ190ZW5hbnQiOiJjYXJib24uc3VwZXIifSwiZXhwIjoxNzYxNTA2OTcwLCJpYXQiOjE3NjE1MDMzNzAsImp0aSI6Ijg1YzdkOTYxLTU2MTMtNGIzZi1hYzllLWNiZWI0YTU0N2RiMyJ9.JtZ5KwbhWYOf51l9GpyDFq33-aYYsMGyfdw_J43ADtaiwvJM565bXJsEuljsK43HL9Dm6WVOu1im55ftgSt5FviLctNqcoyqYITia4R9fjGc72cSpQCo_cStece8Jlpeblse03rFjmr_9Mn2_ZSezW47quP8yiqDtYN00WcKw8eHc4QwXpw4fwshK4RFgduG5Yu7GXmAaRXGB-W-MyPArWBn8C_95CC9vWYju1L_VRMz_Z4uuC5ZX9VutNk7m_kQuI5DFP3jVwsbooQScyTbIdOFDnyds6bH-LfSNsQ9PbMKqeflFBLC22DDUEkHFefH71TiQ6e13BLsfBMTMstKNg`, 
    'X-CorrelationID': '123456789', 
    'UserLanguage': 'FR',
    'UserAccountIdentifier': 'msisdn:0343500004', 
    'partnerName': 'MVola_App_Test' 
  }
})


export async function getData<T>(endpoint: string): Promise<T> {
  const { data } = await api.get(endpoint)
  return data
}


export async function makeMerchantPay<T>(payload: any): Promise<T> {
  const { data } = await api.post(
    '/transactions/type/merchantpay/1.0.0',
    payload
  )
  return data
}

export default api
