import cv2
import numpy as np
from imutils import perspective
import sys
import os.path

def cutImage(inPath, outPath, resizeWidth = 200, maxRadius = 15, thMin = 50, blurNum = 5, radiusNum = 5, borderNum = 5, calcMissPoint = False):
img_rgb = cv2.imread(inPath)
if borderNum > 0:
img_rgb = cv2.copyMakeBorder(img_rgb, borderNum, borderNum, borderNum, borderNum, cv2.BORDER_CONSTANT, value=(255,255,255))
height, width = img_rgb.shape[:2]
w = resizeWidth
h = height * resizeWidth / width

image = cv2.resize(img_rgb, (w, h), interpolation=cv2.INTER_AREA)
gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
blurred = cv2.medianBlur(gray, blurNum)
(_, thresh) = cv2.threshold(blurred, thMin, 255, cv2.THRESH_BINARY)
contours, hierarchy = cv2.findContours(thresh,cv2.RETR_TREE,cv2.CHAIN_APPROX_SIMPLE)
yRange = getPointYRange(h)
points = []
ptsWithRadius = []
for cnt in contours:
(x,y),radius = cv2.minEnclosingCircle(cnt)
center = (int(x),int(y))
if radius > maxRadius or (radius < radiusNum and center[0] >= radiusNum + borderNum and center[1] >= radiusNum + borderNum) or gray[center[1], center[0]] > thMin:
continue
elif center[1] > yRange[0][0] and center[1] < yRange[0][1]:
points.append(center)
ptsWithRadius.append((center, radius))
elif center[1] > yRange[1][0] and center[1] < yRange[1][1]:
points.append(center)
ptsWithRadius.append((center, radius))
else:
continue
radius = int(radius)
cv2.circle(image,center,radius,(0,255,0),1)
show(image)
if len(points) == 3 and calcMissPoint:
points.append(getMissPoint(points))
if len(points) > 4:
ptsWithRadius.sort(key=lambda pt : pt[1], reverse=True)
points = []
for i in range(4):
points.append(ptsWithRadius[i][0])
if len(points) != 4:
return False

img_rgb = perspective.four_point_transform(image,np.array(points))
show(img_rgb)
height, width = img_rgb.shape[:2]
oX = width / 2.0
oY = height / 6.0

x1 = int(oX / 4)
x2 = int(oX - oX / 4)
x3 = int(oX + oX / 4)
x4 = int(width - oX / 4)

for i in range(6):
y1 = int(oY * i + oY / 3)
y2 = int(oY * (i + 1) - oY / 3)
if  i > 3:
y1 = y1 - int(oY / 8)
y2 = y2 - int(oY / 8)
else:
y1 = y1 + int(oY / 8)
y2 = y2 + int(oY / 8)
save(outPath, str(i) + "_0.jpg", img_rgb[y1:y2, x1:x2])
save(outPath, str(i) + "_1.jpg", img_rgb[y1:y2, x3:x4])

cv2.rectangle(img_rgb, (x1, y1), (x2, y2), (0, 255, 0), 1)
show(img_rgb)
return True

def CutImage(inPath, outPath, resizeWidth = 200, maxRadius = 15, thMin = 50, blurNum = 5, radiusNum = 5, borderNum = 5):
for i in range(3):
if cutImage(inPath, outPath, thMin=thMin + 3 * i):
return True
return False

def show(img, name="unamed"):
cv2.imshow(name, img)
cv2.waitKey()

def save(path, name, img):
if not os.path.isdir(path):
os.mkdir(path)
cv2.imwrite(os.path.join(path, name), img)

def getPointYRange(y):
return (0, y / 5), (y * 4 / 5, y)

def getMissPoint(points):
pts = np.array(points)
xSorted = pts[np.argsort(pts[:, 0]), :]
print pts
exit()

leftMost = xSorted[:2, :]
rightMost = xSorted[2:, :]

leftMost = leftMost[np.argsort(leftMost[:, 1]), :]
(tl, bl) = leftMost

D = dist.cdist(tl[np.newaxis], rightMost, "euclidean")[0]
(br, tr) = rightMost[np.argsort(D)[::-1], :]

# return the coordinates in top-left, top-right,
# bottom-right, and bottom-left order
return np.array([tl, tr, br, bl], dtype="float32")

if __name__ == "__main__":
inPath = sys.argv[1]
outPath = sys.argv[2]

if not CutImage(inPath, outPath, thMin):
exit(-1)
