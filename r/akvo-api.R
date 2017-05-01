library(digest)
library(RCurl)
library(jsonlite)

#EXAMPLE: replace the values below to fit your actual server and API values
base_url <- 'https://myorg.akvoflow.org'
version_prefix <- '/api/v1'
secret = 'dsfsdfjsdhfkjhk='
access_id = 'hjsdhfkhsdfkjh='
# --------------------------

ampersand = '&'

expires <- round(as.numeric(as.POSIXct(Sys.time())))
end_point = '/surveys'
resource = paste0(version_prefix,end_point)
arguments = ''

payload = paste('GET',expires,resource, sep='\n')

hmac_hash <- hmac(key=secret, object=payload, algo="sha1", raw = TRUE)
signature_base64 <- base64(hmac_hash)

url <- paste0(base_url, resource)

response = basicTextGatherer()
curlPerform(url=url, httpheader=c(Date=expires, Authorization=paste(access_id,signature_base64,sep=":")), writefunction=response$update, verbose=TRUE)
cat(response$value())

responseJSON <- fromJSON(response$value())
View(responseJSON[1])