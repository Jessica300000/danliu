#load the dataset
fb_data = read.csv("/Users/andyliu/Downloads/Facebook_metrics/dataset_Facebook.csv", sep = ";",header = T)

attach(fb_data)  
#population size for different Categories 
N.h <- tapply(Lifetime.Post.Total.Impressions, Category, length) 
#name of the Categories
Categories <- names(N.h)
Categories  
N.h
detach(fb_data)

N <- sum(N.h)

#The code for SRS
#Population mean of Lifetime.Post.Total.Impressions
true.value <- mean(fb_data$Lifetime.Post.Total.Impressions) 
true.value 
#Calculate suitable sample size

#Total sample size 
n <- 50 
#Initialize the SRS sample
set.seed(10) 
SRS.indices <- sample.int(N,  n, replace = F) 
SRS.sample <- fb_data[SRS.indices , ] 
# sample mean 
SRS.sample.mean <- mean(SRS.sample$Lifetime.Post.Total.Impressions)  
SRS.sample.mean

# sample variance 
SRS.sample.variance = var(SRS.sample$Lifetime.Post.Total.Impressions) 

# sample standard deviation 
SRS.sd = sqrt(SRS.sample.variance) 


# calculate 95% CI for population mean 
SRS.se <- sqrt( (1-n/N)/n )*SRS.sd 
SRS.se
SRS.CI <- c(SRS.sample.mean - 1.96 * SRS.se, SRS.sample.mean + 1.96 * SRS.se) 
SRS.CI 
srs <- c(est_ybar=SRS.sample.mean, est_se=SRS.se) 

#The code for Stratified Sampling with proportional allocation 
#Initialize the stratified sample
#h subpopulation sample size
n.h.prop <- round( (N.h/N) * n)  
STR.sample.prop <- NULL 
for (i in 1: length(Categories)) 
{  
  row.indices <- which(fb_data$Category == Categories[i]) 
  sample.indices <- sample(row.indices, n.h.prop[i], replace = F) 
  STR.sample.prop <- rbind(STR.sample.prop, fb_data[sample.indices, ])    
} 

ybar.h.prop <- tapply(STR.sample.prop$Lifetime.Post.Total.Impressions, STR.sample.prop$Category, mean)  
var.h.prop <- tapply(STR.sample.prop$Lifetime.Post.Total.Impressions, STR.sample.prop$Category, var)  
se.h.prop <- sqrt((1 - n.h.prop / N.h) * var.h.prop / n.h.prop)   
rbind(ybar.h.prop, se.h.prop) 

#Stratified sample mean of Lifetime.Post.Total.Impressions
ybar.str.prop  <- sum(N.h / N * ybar.h.prop) 
#Standard error of ybar.str.prop
se.str.prop <- sqrt(sum((N.h / N)^2 * se.h.prop^2))  
str.prop <- c(est_ybar=ybar.str.prop , est_se=se.str.prop) 
#95% CI for population mean 
lower.bound <- ybar.str.prop -1.96*se.str.prop
lower.bound
upper.bound <- ybar.str.prop +1.96*se.str.prop
upper.bound
str.95CI <- c(lower.bound,upper.bound)

rbind(srs=srs, str=str.prop)

#estimate the proportion of posts whose likes are more than 20000
#SRS
SRS.sample2 = SRS.sample[SRS.sample$Lifetime.Post.Total.Impressions >=20000,]
SRS.p=length(SRS.sample2$Lifetime.Post.Total.Impressions)/length(SRS.sample$Lifetime.Post.Total.Impressions)
SRS.sample.p.mean = SRS.p
SRS.sample.p.mean
SRS.se.p = sqrt((1 - n / N)*SRS.p*(1-SRS.p)/n)
SRS.se.p
SRS.p.CI <- c(SRS.sample.p.mean - 1.96 * SRS.se.p, SRS.sample.p.mean + 1.96 * SRS.se.p) 
SRS.p.CI 
srsp <- c(est_prop=SRS.p,est_se=SRS.se.p)

#The code for Stratified Sampling with proportional allocation 
STR.sample.c1 <- STR.sample.prop$Lifetime.Post.Total.Impressions[fb_data$Category==1]
STR.sample.c2 <- STR.sample.prop$Lifetime.Post.Total.Impressions[fb_data$Category==2]
STR.sample.c3 <- STR.sample.prop$Lifetime.Post.Total.Impressions[fb_data$Category==3]

c1 <- length(na.omit(STR.sample.c1[STR.sample.c1>=20000]))/length(na.omit(STR.sample.c1))
c2 <- length(na.omit(STR.sample.c1[STR.sample.c2>=20000]))/length(na.omit(STR.sample.c2))
c3 <- length(na.omit(STR.sample.c1[STR.sample.c2>=20000]))/length(na.omit(STR.sample.c3))

phat.h.prop <- c(c1,c2,c3)
phat.var.h.prop <- c(c1*(1-c1),c2*(1-c2),c3*(1-c3))
phat.se.h.prop <- sqrt((1 - n.h.prop / N.h) * phat.var.h.prop / n.h.prop)   
rbind(phat.h.prop, phat.se.h.prop) 

phat.str.prop <- sum(N.h / N * phat.h.prop)  
phat.str.prop
phat.se.str.prop <- sqrt(sum((N.h / N)^2 * phat.se.h.prop^2))  
#phat.se.str.prop <- sqrt(sum((N.h / N)^2 *(1 - n.h.prop / N.h) * phat.var.h.prop / n.h.prop))
phat.se.str.prop
str.prop <- c(phat.str.prop, phat.se.str.prop) 
lower.bound <- phat.str.prop-1.96*phat.se.str.prop
lower.bound
upper.bound <- phat.str.prop+1.96*phat.se.str.prop
upper.bound
str.95CI <- cbind(lower.bound,upper.bound)
strp.prop <- c(phat.str.prop,phat.se.str.prop)

rbind(srs=srsp, str=strp.prop)

